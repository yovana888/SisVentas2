<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Notificacion_Pedido;
use sisVentas\DetalleNotPedido;
use sisVentas\Http\Requests\NotificacionPedFormRequest;
use DB;
use Fpdf;
use \PDF;
use DomPdf;
use Auth;
use Alert;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class PedidoEntraController extends Controller
{
  public function __construct()
{
    $this->middleware('auth');
}

public function index(Request $request)
{
          $idsucursal=Auth::user()->id_s;
          $sucursales=DB::table('sucursal')->get();

          //le mandamos para el index
          $pedidos=DB::table('notificacion_pedido as nt')
          ->join('detalle_pedido as d','d.idnotificacion_pedido','=','nt.idnotificacion_pedido')
          ->where('d.idsucursal','=',$idsucursal)
          ->where('nt.pedido_prov','=','0')
          ->groupBy('nt.idnotificacion_pedido')
          ->get();

            $details=DB::table('detalle_pedido as dp')
            ->join('detalle_articulo as da','da.iddetalle_articulo','=','dp.idarticulo')
            ->join('articulo as art','art.idarticulo','=','da.idarticulo')
            ->select(DB::raw('CONCAT(da.codigo, " ",art.nombre, " color ",da.etiqueta) AS articulo'),'dp.iddetalle_pedido','da.UN1','da.UN2','da.tam_nro1','da.tam_nro2','da.num_stock_gn','dp.cantidad','dp.pp','dp.idsucursal','dp.cant_pp','dp.idnotificacion_pedido')
            ->get();
        

          return view('pedidos/entrantes/index',["sucursales"=>$sucursales,"pedidos"=>$pedidos,"details"=>$details]);

}

public function byupdate($id1,$id2,$id3){
  //recibiendo del ajax
  //id1 id de dettalle, id2 la cantidad y el otro es la cantidad del proveedor
  DB::table('detalle_pedido as dp')
      ->where('dp.iddetalle_pedido', $id1 )
      ->update(['dp.cantidad'=>$id2,'dp.cant_pp'=>$id3]);
       
}

public function edit($id)
{
   return view("pedidos.entrantes.show",["pedido"=>Notificacion_Pedido::findOrFail($id)]);
}


public function update(NotificacionPedFormRequest $request,$id)
{
    //lo primero q se hara sera verificar si se hara pedido_proveedor
            $buscar=DB::table('detalle_pedido as dt')
            ->where('dt.idnotificacion_pedido','=',$id)
            ->where('dt.cant_pp','>=','1')
            ->get();

            $id_emi=$request->get('emisor');
            $id_nota=$request->get('nota');
            $mytime = Carbon::now('America/Lima');
            if(count($buscar)>0){
                //entonces creamos la notificacion tipo proveedor
                  $pedido_p=new Notificacion_Pedido;
                  $pedido_p->idemisor=$id_emi;
                  $pedido_p->fecha_hora=$mytime->toDateTimeString();
                  $pedido_p->nota='Proviene de Pedido entrante N° '.$id;
                  $pedido_p->estado='En espera';
                  $pedido_p->pedido_prov='1';
                  $pedido_p->save();
                //ahora los detalles

                foreach ($buscar as $bus) {
                  $pedido_d=new DetalleNotPedido;
                  $pedido_d->idnotificacion_pedido=$pedido_p->idnotificacion_pedido;
                  $pedido_d->idarticulo=$bus->idarticulo;
                  $pedido_d->cantidad=0;
                  //quiere decir q se paso algunos articulos al proveedor, por lo que editamos pp=0=pasado a proveedor
                  $pedido_d->pp=0;    
                  $pedido_d->idsucursal=$bus->idsucursal;
                  $pedido_d->cant_pp=$bus->cant_pp;
                  $pedido_d->idproveedor=$bus->idproveedor;
                  $pedido_d->save();
                }

              DB::table('notificacion_pedido as np')
              ->where('np.idnotificacion_pedido','=', $id)
              ->update(['np.estado'=>'Acep. Parcial']); 
            }else{

              //no se hace nada :v
               DB::table('notificacion_pedido as np')
              ->where('np.idnotificacion_pedido','=', $id)
              ->update(['np.estado'=>'Aceptado']); 

            }
            //editamos la nota 

           if($id_nota=='' || $id_nota=='-'){
              #misma nota
              
           }else{

               DB::table('notificacion_pedido as np')
              ->where('np.idnotificacion_pedido','=', $id)
              ->update(['np.nota'=>$id_nota]);
           }

            //Lo siguiente será crear el traslado es decir actualizaremos el stock del emisor  :v
            # W O R D S - Sub Español (Anime)
            #para ello verificamos donde estamos y quien es el emisor aaa
             $idsucursal=Auth::user()->id_s;
             $buscar2=DB::table('detalle_pedido as dt')
            ->where('dt.idnotificacion_pedido','=',$id)
            ->get();

             if($idsucursal=='3'){
              //estoy en almacen , entonces el emisor es de la tabla traslado 
                foreach ($buscar2 as $bus2) {

                    $stock_ant=DB::table('traslado as tr')
                    ->select('tr.stock','tr.idtraslado')
                    ->where('tr.idsucursal','=',$id_emi)
                    ->where('tr.idarticulo','=',$bus2->idarticulo)
                    ->get();

                    foreach ($stock_ant as $key ) {
                      $stock_ant1=$key->stock;
                      $id_tr=$key->idtraslado;
                    }

                    $nuevo_stock=$stock_ant1+$bus2->cantidad;
                    //editamos
                    DB::table('traslado as tr')
                    ->select('tr.stock')
                    ->where('tr.idtraslado','=',$id_tr)
                    ->update(['tr.stock'=>$nuevo_stock]);

                    ############## editando ahora mi stock desde mi sucursal 
                    $mistock_a=DB::table('detalle_articulo as da')
                    ->select('da.num_stock_gn')
                    ->where('da.iddetalle_articulo','=',$bus2->idarticulo)
                    ->get();

                    foreach ($mistock_a as $ma ) {
                      $stock_ant2=$ma->num_stock_gn;
                    }
                    $nuevo_stock2=$stock_ant2-$bus2->cantidad;
                    //editamos
                     DB::table('detalle_articulo as da')
                    ->where('da.iddetalle_articulo','=',$bus2->idarticulo)
                    ->update(['da.num_stock_gn'=>$nuevo_stock2]);

                    //Agregando Movimiento para mi
                    DB::table('movimiento')->insert(['idarticulo' =>  $bus2->idarticulo, 'tipo_movimiento' => 'Salida' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cantidad, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$idsucursal,'nota'=>'-']);

                  //Agregando movimiento para él
                   DB::table('movimiento')->insert(['idarticulo' => $bus2->idarticulo, 'tipo_movimiento' => 'Entrada' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cantidad, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$id_emi,'nota'=>'-']); 

              }

             }else{
                //estoy en sucursal .... , hay q ver quien es el emisor que quiere el pedido

                 if($id_emi==3){
                    //entonces resto mi stock y actualizo el almacen

                        foreach ($buscar2 as $bus2) {
        

                            $stock_ant=DB::table('detalle_articulo as da')
                            ->select('da.num_stock_gn')
                            ->where('da.iddetalle_articulo','=',$bus2->idarticulo)
                            ->get();

                            foreach ($stock_ant as $key ) {
                              $stock_ant1=$key->num_stock_gn;
                            }

                            $nuevo_stock=$stock_ant1+$bus2->cantidad;
                            //editamos

                            DB::table('detalle_articulo as da')
                            ->where('da.iddetalle_articulo','=',$bus2->idarticulo)
                            ->update(['da.num_stock_gn'=>$nuevo_stock]);

                         
                            ############## editando ahora mi stock desde mi sucursal *traslado
                            $mistock_a=DB::table('traslado as tr')
                            ->select('tr.stock','tr.idtraslado')
                            ->where('tr.idsucursal','=',$idsucursal)
                            ->where('tr.idarticulo','=',$bus2->idarticulo)
                            ->get();

                            foreach ($mistock_a as $ma ) {
                              $stock_ant2=$ma->stock;
                              $id_tr=$ma->idtraslado;
                            }
                            $nuevo_stock2=$stock_ant2-$bus2->cantidad;
                            //editamos
                             DB::table('traslado as tr')
                            ->where('tr.idtraslado','=',$id_tr)
                            ->update(['tr.stock'=>$nuevo_stock2]); 

                            //Agregando Movimiento para mi
                              DB::table('movimiento')->insert(['idarticulo' =>  $bus2->idarticulo, 'tipo_movimiento' => 'Salida' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cantidad, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$idsucursal,'nota'=>'-']);

                            //Agregando movimiento para él
                              DB::table('movimiento')->insert(['idarticulo' => $bus2->idarticulo, 'tipo_movimiento' => 'Entrada' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cantidad, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$id_emi,'nota'=>'-']); 

                      }

                 }else{
                    //entonces es de sucursal a sucursal o almacen secundario, es decir la misma tabla traslado

                       foreach ($buscar2 as $bus2) {
        
                            $stock_ant=DB::table('traslado as tr')
                            ->select('tr.stock','tr.idtraslado')
                            ->where('tr.idsucursal','=',$id_emi)
                            ->where('tr.idarticulo','=',$bus2->idarticulo)
                            ->get();

                            foreach ($stock_ant as $key ) {
                              $stock_ant1=$key->stock;
                              $id_tr=$key->idtraslado;
                            }

                            $nuevo_stock=$stock_ant1+$bus2->cantidad;
                            //editamos
                            DB::table('traslado as tr')
                            ->select('tr.stock')
                            ->where('tr.idtraslado','=',$id_tr)
                            ->update(['tr.stock'=>$nuevo_stock]);
                                 
                            ############## editando ahora mi stock desde mi sucursal *traslado
                            $mistock_a=DB::table('traslado as tr')
                            ->select('tr.stock','tr.idtraslado')
                            ->where('tr.idsucursal','=',$idsucursal)
                            ->where('tr.idarticulo','=',$bus2->idarticulo)
                            ->get();

                            foreach ($mistock_a as $ma ) {
                              $stock_ant2=$ma->stock;
                              $id_tr=$ma->idtraslado;
                            }
                            $nuevo_stock2=$stock_ant2-$bus2->cantidad;
                            //editamos
                             DB::table('traslado as tr')
                            ->where('tr.idtraslado','=',$id_tr)
                            ->update(['tr.stock'=>$nuevo_stock2]);

                              //Agregando Movimiento para mi
                              DB::table('movimiento')->insert(['idarticulo' =>  $bus2->idarticulo, 'tipo_movimiento' => 'Salida' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cantidad, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$idsucursal,'nota'=>'-']);

                            //Agregando movimiento para él
                              DB::table('movimiento')->insert(['idarticulo' => $bus2->idarticulo, 'tipo_movimiento' => 'Entrada' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cantidad, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$id_emi,'nota'=>'-']); 

                      }
                 }
             
        }

     Alert::success('El traslado fue realizado exitosamente', 'Mensaje del Sistema')->persistent("Close");
     return Redirect::to('pedidos/entrantes');     

  }
}