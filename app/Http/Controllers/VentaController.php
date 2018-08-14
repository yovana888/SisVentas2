<?php

namespace sisVentas\Http\Controllers;
use Illuminate\Http\Request;
use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\VentaFormRequest;
use sisVentas\Venta;
use sisVentas\DetalleVenta;
use sisVentas\Persona;
use sisVentas\Credito;
use sisVentas\Movimiento;
use sisVentas\Sucursal;
use sisVentas\User;
use DB;
use Fpdf;
use \PDF;
use DomPdf;
use Auth;
use Alert;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
           $sucursal=Auth::user()->id_s;
         
           $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.nota','v.descuento')
            ->orderBy('v.idventa','desc')
            ->get();

              $detalles=DB::table('detalle_venta as dv')
              ->join('detalle_articulo as da','da.iddetalle_articulo','=','dv.idarticulo')
              ->join('articulo as a','a.idarticulo','=','da.idarticulo')
              ->select('dv.iddetalle_venta',DB::raw('CONCAT(da.codigo, " ",a.nombre, " color ",da.etiqueta) AS articulo'),'dv.cantidad','dv.subtotal','dv.precio_venta','dv.descuento','da.medida_stock_det','da.medida_stock_gn','dv.idventa','da.UN2','da.UN1','da.tam_nro1','da.tam_nro2','dv.unidad')
              ->get(); 

        
            return view('ventas.venta.index',["ventas"=>$ventas,"detalles"=>$detalles]);

        
    }
    public function create()
    {
         $sucursal=Auth::user()->id_s;

        /*Autogenerando numero de comprobante*/
         $number=DB::table('venta')
        ->select(DB::raw('MAX(idventa) as g'))
        ->where('idsucursal',$sucursal)
        ->get();
        
        foreach ($number as $key ) {
          $keynew=$key->g;
        }
         
         //de lo anterior obtendremos el registro con sus datos

        $compro=DB::table('venta as v')
        ->select('num_comprobante','serie_comprobante')
        ->get();

        if(count($compro)==0){

            $num_s='0001';
            $correlativo='000001';

        }else{

            foreach ($compro as $cm) {
                 $num_s=$cm->serie_comprobante;
                 $correlativo0=$cm->num_comprobante;
            }


             //correlativo aumentar en 1, pero es un '0000'
                $conv=(int)$correlativo0;
                $incre=$conv+1;

               //reconstruimos cadena  
                $tama= 6 - strlen($incre);
                $base=0;
                $ct0=0;
                for ($i=0; $i < $tama-1; $i++) { 
                     $ct0=$ct0.$base;     
                }

                $correlativo=$ct0.$incre;

        }



        	$personas=DB::table('persona as p')
            ->where('p.idsucursal','=',$sucursal)
            ->where('tipo_persona','=','Cliente')->get();
        
    
            $empleados=DB::table('users as u')
            ->join('user_sucursal as us','us.iduser','=','u.id')
            ->select('u.dni','u.id','u.name')
            ->where('us.idsucursal','=',$sucursal)
            ->where('us.estado','=','Activo')->get();
        
            $articulos=DB::table('traslado as t')
            ->join('detalle_articulo as da','da.iddetalle_articulo','=','t.idarticulo')
            ->join('articulo as art','art.idarticulo','=','da.idarticulo')
            ->select(DB::raw('CONCAT(da.codigo, " ",art.nombre, " color ",da.etiqueta) AS articulo'),'da.iddetalle_articulo','da.medida_stock_gn','da.medida_stock_det','da.UN2','da.UN1','da.tam_nro1','da.tam_nro2', 'da.imagen', 't.stock','t.precio_venta','t.precio_detalle', 't.idtraslado','t.cantidad_detalle')
            ->where('t.idsucursal','=',$sucursal)
            ->get();

    	
        return view("ventas.venta.create",["personas"=>$personas,"empleados"=>$empleados,"articulos"=>$articulos,"num_s"=>$num_s, "correlativo"=>$correlativo]);
    }
    
     public function byDetalles($id){
        $resul=DB::table('traslado')->where('idtraslado','=',$id)->get();
        return $resul;
     }



     public function store (VentaFormRequest $request)
    {
         $sucursal=Auth::user()->id_s;
         $venta=new Venta;
         $venta->idcliente=$request->get('idcliente');
         $venta->iduser=$request->get('idempleado');
         $venta->idsucursal=Auth::user()->id_s;
         $venta->serie_comprobante=$request->get('serie');
         $venta->num_comprobante=$request->get('corre');
         $mytime = Carbon::now('America/Lima');
         $venta->fecha_hora=$mytime->toDateTimeString();
         $venta->impuesto=0;
         $venta->cambio=$request->get('cambio');
         $ver=$request->get('des_global');
         if($ver=='0'){
            $venta->total_venta=$request->get('tot');
         }else{
            $venta->total_venta=$request->get('adios');
         }
         $venta->nota=$request->get('nota');
         $venta->descuento=$request->get('des_global');
         $ded=$request->get('deuda');

         if($ded==0){
            $venta->estado='Aceptado';
         }else{
            $venta->estado='Por Cobrar';
         }
         //para estado
         $venta->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad_dt');
            $descuento = $request->get('descuento');
            $precio_venta = $request->get('precio_unit');
            $tipo = $request->get('tipo');
             $cont = 0;

             while($cont < count($idarticulo)){
                $detalle = new DetalleVenta();
                $detalle->idventa= $venta->idventa; 
                $detalle->idarticulo= $idarticulo[$cont];
                $sucursal_a=Auth::user()->id_s; 
                //Ahora el movimiento
                $mytime3 = Carbon::now('America/Lima');
                DB::table('movimiento')->insert(
                ['idarticulo' => $idarticulo[$cont], 'tipo_movimiento' => 'Salida' ,'motivo' => 'Venta', 'cantidad' => $cantidad[$cont], 'estado' => 'Activo' , 'fecha_mov' => $mytime3->toDateTimeString(),'idsucursal' =>$sucursal_a,'nota'=>'-']);  
                //con descuento*art
                //aaa pero falto actualizar articulo

                 //
                  $id_tr=DB::table('traslado as t')
                  ->join('detalle_articulo as da','da.iddetalle_articulo','=','t.idarticulo')
                  ->select('t.stock','t.cantidad_detalle','t.idtraslado','da.tam_nro2')
                  ->where('t.idsucursal', $sucursal)
                  ->where('t.idarticulo', $idarticulo[$cont])
                  ->get();

                  foreach ($id_tr as $idt) {
                      $id_bu=$idt->stock;
                      $id_bu2=$idt->idtraslado;
                      $id_bu3=$idt->cantidad_detalle;
                      $id_bu4=$idt->tam_nro2;
                  }



                  if($tipo[$cont]=='normal'){
                      $news=$id_bu-$cantidad[$cont];
                      DB::table('traslado as t')->where('t.idtraslado', $id_bu2 )->update(['t.stock' =>$news]);
                      $detalle->unidad='normal';
                  }else{
                      $pre= ($id_bu*$id_bu4+$id_bu3)-$cantidad[$cont]; //total de metros en general - lo q estoy vendiendo
                      $resto=$pre%$id_bu4;
                      $div=$pre/$id_bu4;
                      $cociente=floor($div);
                      DB::table('traslado as t')->where('t.idtraslado', $id_bu2 )->update(['t.stock' =>$cociente,'t.cantidad_detalle'=>$resto]);
                      $detalle->unidad='detalle';
                  }
                

                    
                $detalle->cantidad= $cantidad[$cont];
                $detalle->descuento= $descuento[$cont];
                $detalle->precio_venta= $precio_venta[$cont];
                $valor=($cantidad[$cont]*$precio_venta[$cont]);
                $detalle->subtotal=$valor-($valor*$descuento[$cont])/100;
                $detalle->save();
                $cont=$cont+1;  
                
            }


            if( $venta->estado=='Por Cobrar'){
                //Entonces nos vamos a la tabla credito
               
                //extraemos nuestro array de creditos con las fechas 

               $fecha_cre = $request->get('fecha_cre');
               $tam_cre=count($fecha_cre); //para saber la cantidad de letras 
               $prox_f=$fecha_cre[0]; //ya q es la primera fecha 
               $credito_g=new Credito;
               $credito_g->idventa=$venta->idventa;
               $credito_g->total=$venta->total_venta;
               $credito_g->fecha_px=$prox_f;
               $credito_g->idsucursal=$sucursal_a;
               $credito_g->resto= $request->get('deuda');
               $credito_g->estado='Por Cobrar';
               $credito_g->cant_letras= $tam_cre;
               $credito_g->save();
               $cancel=$credito_g->total - $credito_g->resto;
               //AHORA DETALLE DE CREDITO, por si pago algo aquel mismo dia 

                    DB::table('detalle_credito')->insert(
                    ['idcredito' => $credito_g->idcredito, 'fecha_pago' => $mytime3->toDateTimeString(),'monto' => $cancel]
                    );
                       //en un while :v K-ON! - Singing! nice 
                         $cont2 = 0;




                         while($cont2 < $tam_cre){
                          //hacemos q se ingrese solo las fechas 

                                       DB::table('detalle_fecha_cre')->insert(
                                      ['idcredito' => $credito_g->idcredito, 'fecha' =>$fecha_cre[$cont2]]
                                      );
                                      //Strike The Blood Opening OVA 0u0
                                      $cont2=$cont2+1;
                                   }
                          
               //ahora para caja solo es lo que cancelo ... claro debe ser diferente de 0 >:v
                      if($cancel==0){
                        //no almacena en caja
                      }else{
                        //almacenamso en caja, para ello el ultimo id por sucursal >:v
                          $mytime5 = Carbon::now('America/Lima');
                          $fecha5 = $mytime5->toDateString();
                          $hora=$mytime5->toTimeString();
                          $sucursal=Auth::user()->id_s;
                          $caja=DB::table('caja')
                          ->select('idcaja','fecha','monto_cierre','estado')
                          ->where('idsucursal','=',$sucursal)
                          ->where('fecha','=',$fecha5)
                          ->get();
                        
                           foreach ($caja as $cj) {
                             $id_ca=$cj->idcaja;
                             $ant=$cj->monto_cierre;
                             $est=$cj->estado; //ver luego en caso de cerrado T.T
                           }

                           $nuevo=$ant + $cancel;

                               DB::table('caja')
                              ->where('idcaja', $id_ca)
                              ->update(['monto_cierre'=>$nuevo]);

                              //ahora el detalle
                              $concate='Venta N° '.' '.$venta->serie_comprobante.'-'.$venta->num_comprobante;
                                  DB::table('detalle_caja')->insert(
                                      ['idcaja' => $id_ca, 'descripcion' =>$concate, "hora"=>$hora, "monto"=>$cancel, "tipo"=>'Entrada']
                                      );


                      }


            }else
            {
                //que no haga nada, ya q esta Aceptado :v , pero se suma el total pagado a caja



                       $mytime5 = Carbon::now('America/Lima');
                          $fecha5 = $mytime5->toDateString();
                          $hora=$mytime5->toTimeString();
                          $sucursal=Auth::user()->id_s;
                          $caja=DB::table('caja')
                          ->select('idcaja','fecha','monto_cierre','estado')
                          ->where('idsucursal','=',$sucursal)
                          ->where('fecha','=',$fecha5)
                          ->get();
                        
                           foreach ($caja as $cj) {
                             $id_ca=$cj->idcaja;
                             $ant=$cj->monto_cierre;
                             $est=$cj->estado; //ver luego en caso de cerrado T.T
                           }

                           $nuevo=$ant + $venta->total_venta;

                               DB::table('caja')
                              ->where('idcaja', $id_ca)
                              ->update(['monto_cierre'=>$nuevo]);

                              //ahora el detalle
                              $concate='Venta N° '.' '.$venta->serie_comprobante.'-'.$venta->num_comprobante;
                                  DB::table('detalle_caja')->insert(
                                      ['idcaja' => $id_ca, 'descripcion' =>$concate, "hora"=>$hora, "monto"=>$venta->total_venta, "tipo"=>'Entrada']
                                      );


            }

        
       Alert::success('La venta se realizó correctamente', 'Mensaje del Sistema')->persistent("Close");


        return Redirect::to('ventas/venta');
    }

    
    

    
    
    public function show($id) //ese is es el id_venta de la tabla venta
    {

    }

    public function destroy($id)
    {
    	$venta=Venta::findOrFail($id);
        $venta->Estado='Anulado';
        $venta->update();
        Alert::success('La venta se anulo correctamente', 'Mensaje del Sistema')->persistent("Close");
        return Redirect::to('ventas/venta');
    }
 
    public function reporte1(){
        
          $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.tipo_venta','v.num_guia','v.serie_guia')
            ->orderBy('v.idventa','desc')
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
            ->get();
        
       // $ventas = Venta::all();
        $pdf = \PDF::loadView('ventas.venta.vista', ["ventas"=>$ventas]);
        //return $pdf->download('archivo.pdf');
        return $pdf->stream();
    }
    
    public  function factura($id){
        
         $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            ->join('users as u','v.iduser','=','u.id')
             ->join('user_sucursal as us','us.iduser','=','u.id')
            ->join('sucursal as s','us.idsucursal','=','s.idsucursal')
            ->select('v.idventa','v.fecha_hora','p.nombre','p.direccion as dip','p.num_documento','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','u.name','s.razon','s.direccion','s.telefono','s.email','s.logo','s.moneda','v.tipo_venta','s.cel','s.ruc','p.ruc as rucp','v.fecha_ven','p.telefono as tel','v.orden','v.referencia','v.cambio','v.num_guia','v.serie_guia','s.igv','s.ir','v.importe')
            ->where('v.idventa','=',$id)
            ->first();
        //calculo de impuesto
            $ig100=$ventas->igv;
            $ig2100=$ig100/100;
            $div=$ig2100+1;
            $tk=$ventas->importe;
            $cal=$tk/$div;
            $cal2=$cal*$ig2100;
            $cal3=round($cal2, 2); 

            
        $detalles=DB::table('detalle_venta as d')
             ->join('articulo as a','d.idarticulo','=','a.idarticulo')
             ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal','d.idventa')
             ->where('d.idventa','=',$id)
             ->get();
        
         //fecha de hoy
         $mytime = Carbon::now('America/Lima');
	        $fe=$mytime;
         $pdf = \PDF::loadView('ventas.venta.vistaid', ["ventas"=>$ventas,"detalles"=>$detalles,"imgn"=>$cal3,"fe"=>$fe]);
        //return $pdf->download('archivo.pdf');
        return $pdf->stream();
    }
    
      public  function ticket($id){
        
         $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            ->join('users as u','v.iduser','=','u.id')
            ->join('user_sucursal as us','us.iduser','=','u.id')
            ->join('sucursal as s','us.idsucursal','=','s.idsucursal')
            ->select('v.idventa','v.fecha_hora','p.nombre','p.num_documento','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','u.name','s.razon','s.direccion','s.telefono','s.moneda','s.celular','s.ruc','p.ruc as rucp','p.telefono as tel','v.cambio','v.total_venta','s.num_maquina','v.estado')
            ->where('v.idventa','=',$id)
            ->first();
        //calculo de impuesto
            $ig100=$ventas->impuesto;
            if($ig100=='0'){
                 $cal3=  $ig100;
            }else{
               
                 $ig2100=$ig100/100;
                $div=$ig2100+1;
                $tk=$ventas->importe;
                $cal=$tk/$div;
                $cal2=$cal*$ig2100;
                 $cal3=round($cal2, 2); 
            }
           
         

        
              $detalles=DB::table('detalle_venta as dv')
              ->join('detalle_articulo as da','da.iddetalle_articulo','=','dv.idarticulo')
              ->join('articulo as a','a.idarticulo','=','da.idarticulo')
              ->select('dv.iddetalle_venta',DB::raw('CONCAT(a.nombre, " color ",da.etiqueta,"/") AS articulo'),'dv.cantidad','dv.subtotal','dv.precio_venta','dv.descuento','da.medida_stock_det','da.medida_stock_gn','dv.idventa','da.medida_stock_gn','da.medida_stock_det','dv.unidad','da.tam_nro1', 'da.UN1')
               ->where('dv.idventa','=',$id)
               ->get(); 

         //fecha de hoy
         $mytime = Carbon::now('America/Lima');
	     $fe=$mytime;
       
         $pdf = \PDF::loadView('ventas.venta.vistaticket', ["ventas"=>$ventas,"detalles"=>$detalles,"imgn"=>$cal3,"fe"=>$fe]);
        
        //return $pdf->download('archivo.pdf');
        return $pdf->setPaper(array(0,0,250,650))->stream();
    }
    
     public  function boleta($id){
        
         $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            ->join('users as u','v.iduser','=','u.id')
            ->join('user_sucursal as us','us.iduser','=','u.id')
            ->join('sucursal as s','us.idsucursal','=','s.idsucursal')
            ->select('v.idventa','v.fecha_hora','p.nombre','p.direccion as dip','p.num_documento','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','u.name','s.razon','s.direccion','s.telefono','s.email','s.logo','s.moneda','v.tipo_venta','s.cel','s.ruc','p.ruc as rucp','v.fecha_ven','p.telefono as tel','v.orden','v.referencia','v.cambio','v.num_guia','v.serie_guia','s.igv','s.ir','v.importe','v.efectivo','v.vuelto','v.fecha_hora','v.observacion')
            ->where('v.idventa','=',$id)
            ->first();
        //calculo de impuesto
            $ig100=$ventas->igv;
            $ig2100=$ig100/100;
            $div=$ig2100+1;
            $tk=$ventas->importe;
            $cal=$tk/$div;
            $cal2=$cal*$ig2100;
             $cal3=round($cal2, 2); 
          /*  $ir1=$ventas->ir;
            $ir2=$ir1/100;
            $ir3=$ir2*$tk;
            $imgn=$cal2+$ir3;*/
            
        $detalles=DB::table('detalle_venta as d')
             ->join('articulo as a','d.idarticulo','=','a.idarticulo')
             ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal','d.idventa')
             ->where('d.idventa','=',$id)
             ->get();
        
         //fecha de hoy
         $mytime = Carbon::now('America/Lima');
	     $fe=$mytime;
       
         $pdf = \PDF::loadView('ventas.venta.vistaboleta', ["ventas"=>$ventas,"detalles"=>$detalles,"imgn"=>$cal3,"fe"=>$fe]);
        
        //return $pdf->download('archivo.pdf');
        return $pdf->setPaper(array(0,0,595,400))->stream();
    }
    
     public  function guia($id){
        
         $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
            ->join('users as u','v.iduser','=','u.id')
            ->join('sucursal as s','u.idsucursal','=','s.idsucursal')
            ->select('v.idventa','v.fecha_hora','p.nombre','p.direccion as dip','p.num_documento','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','u.name','s.razon','s.direccion','s.telefono','s.email','s.logo','s.moneda','v.tipo_venta','s.cel','s.ruc','p.ruc as rucp','v.fecha_ven','p.telefono as tel','v.orden','v.referencia','v.cambio','v.num_guia','v.serie_guia','s.igv','s.ir','v.importe','v.efectivo','v.vuelto','v.fecha_hora','v.observacion','v.fecha_guia','v.serie_guia','v.num_guia','v.p_partida','v.p_llegada','v.non_t','v.m_p','v.licencia','v.ruc_t','v.motivo')
            ->where('v.idventa','=',$id)
            ->first();
        //calculo de impuesto
            $ig100=$ventas->igv;
            $ig2100=$ig100/100;
            $div=$ig2100+1;
            $tk=$ventas->importe;
            $cal=$tk/$div;
            $cal2=$cal*$ig2100;
             $cal3=round($cal2, 2); 
        
            
        $detalles=DB::table('detalle_venta as d')
             ->join('articulo as a','d.idarticulo','=','a.idarticulo')
             ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.subtotal','d.idventa','d.peso')
             ->where('d.idventa','=',$id)
             ->get();
        
         //fecha de hoy
         $mytime = Carbon::now('America/Lima');
	     $fe=$mytime;
       
         $pdf = \PDF::loadView('ventas.venta.vistaguia', ["ventas"=>$ventas,"detalles"=>$detalles,"imgn"=>$cal3,"fe"=>$fe]);
        
        //return $pdf->download('archivo.pdf');
        return $pdf->stream();
    }
}





