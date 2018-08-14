<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Notificacion_Pedido;
use sisVentas\DetalleNotPedido;
use sisVentas\Http\Requests\NotificacionPedFormRequest;
use DB;
use DomPdf;
use Auth;
use Alert;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class PedidoProveedorController extends Controller
{
    //se viene lo mejor :v
         public function __construct()
         {
             $this->middleware('auth');

         }

         public function byresumen($id){
            $ad=DB::table('detalle_pedido as dp')
             ->join('notificacion_pedido as c','c.idnotificacion_pedido','=','dp.idnotificacion_pedido')
             ->join('detalle_articulo as da','da.iddetalle_articulo','=','dp.idarticulo')
             ->join('articulo as art','da.idarticulo','=','art.idarticulo')
             ->select(DB::raw('CONCAT(art.nombre, " color ",da.etiqueta,"/",da.tam_nro1,da.UN1,"-",da.tam_nro2,da.UN2) AS articulo_com'),'dp.idproveedor',DB::raw('SUM(cant_pp) as total'))
            ->where('c.estado','!=','Aceptado')
            ->where('dp.idproveedor','=',$id)
            ->where('c.pedido_prov','=','1')
            ->groupBy('dp.idproveedor')
            ->get();

            return $ad;
          
          }

         public function index(Request $request)
		 {
          $idsucursal=Auth::user()->id_s;
          $sucursales=DB::table('sucursal')->get(); //par ver quien pide al proveedor 

          //le mandamos para el index, muy independiente quien lo pida .... 
           $pedidos=DB::table('notificacion_pedido as nt')
           ->where('nt.pedido_prov','=','1')
           ->get();


              $proveedores2=DB::table('detalle_pedido as dp')
               ->join('notificacion_pedido as np','np.idnotificacion_pedido','=','dp.idnotificacion_pedido')
               ->join('persona as p','p.idpersona','=','dp.idproveedor')
               ->select('p.idpersona','p.nombre','p.email','p.telefono')
               ->where('np.estado','!=','Aceptado')
               ->groupBy('dp.idproveedor')
                ->get();


              $misarticulos_sin = DB::table('detalle_articulo as da')
             ->join('articulo as art','art.idarticulo','=','da.idarticulo')
             ->select(DB::raw('CONCAT(da.codigo, " ",art.nombre, " color ",da.etiqueta) AS articulo'),'da.iddetalle_articulo','da.UN1','da.UN2','da.tam_nro1','da.tam_nro2')
             ->orderBy('da.iddetalle_articulo','desc')
             ->get();

              $misarticulos_con=DB::table('detalle_articulo as da')
             ->join('articulo as art','art.idarticulo','=','da.idarticulo')
             ->select(DB::raw('CONCAT(da.codigo, " ",art.nombre, " color ",da.etiqueta) AS articulo'),'da.iddetalle_articulo','da.UN1','da.UN2','da.tam_nro1','da.tam_nro2')
             ->groupBy('da.iddetalle_articulo')
             ->havingRaw('SUM(da.stockmin-da.num_stock_gn) >= 0')
             ->get();

             $details=DB::table('detalle_pedido as dp')
            ->join('persona as p','p.idpersona','=','dp.idproveedor')
            ->join('detalle_articulo as da','da.iddetalle_articulo','=','dp.idarticulo')
            ->join('articulo as art','art.idarticulo','=','da.idarticulo')
            ->select(DB::raw('CONCAT(da.codigo, " ",art.nombre, " color ",da.etiqueta) AS articulo'),'dp.idarticulo','dp.iddetalle_pedido','da.UN1','da.UN2','da.tam_nro1','da.tam_nro2','da.num_stock_gn','dp.cantidad','dp.pp','dp.idsucursal','dp.cant_pp','dp.idnotificacion_pedido','dp.idproveedor','p.nombre')
            ->get();


          return view('pedidos/proveedor/index',["misarticulos_sin"=>$misarticulos_sin,"misarticulos_con"=>$misarticulos_con,"sucursales"=>$sucursales,"pedidos"=>$pedidos,"details"=>$details,"proveedores2"=>$proveedores2]);

	     }

       public function byupdate($id1,$id2){
          //recibiendo del ajax
          //id1 id de dettalle,  el otro es la cantidad del proveedor
          DB::table('detalle_pedido as dp')
              ->where('dp.iddetalle_pedido', $id1)
              ->update(['dp.cant_pp'=>$id2]);
               
        }

        public function bymostrar($id){
          //recibiendo del ajax
          //id es el id del articulo 
          $articulosfiltro=DB::table('detalle_proveedor as dp')
          ->join('persona as p','p.idpersona','=','dp.idproveedor')
          ->select('dp.idproveedor','p.nombre')
          ->where('dp.idarticulo','=',$id)
          ->get();

          return $articulosfiltro;
               
        }

        public function edit($id)
        {
           return view("pedidos.proveedor.show",["pedido"=>Notificacion_Pedido::findOrFail($id)]);
        }


        public function update(NotificacionPedFormRequest $request,$id)
        {
    
           //editamos la nota http://diposit.ub.edu/dspace/bitstream/2445/67906/2/memoria.pdf   http://repository.lasalle.edu.co/bitstream/handle/10185/3968/45101402_2014.pdf?sequence=3   
          //https://es.slideshare.net/cumanadigital/diagramas-de-clases-secuencia-patrones-de-diseo-mvc-diso-de-interfaces-de-usuario-para-proyecto-gesti-de-ausentismo-zona-educativa

          
            $id_emi=$request->get('emisor');
            $id_nota=$request->get('nota');
            $mytime = Carbon::now('America/Lima');

             if($id_nota=='' || $id_nota=='-'){
              #misma nota
              DB::table('notificacion_pedido as np')
                ->where('np.idnotificacion_pedido','=', $id)
                ->update(['np.estado'=>'Aceptado']);
              
             }else{

                 DB::table('notificacion_pedido as np')
                ->where('np.idnotificacion_pedido','=', $id)
                ->update(['np.nota'=>$id_nota,'np.estado'=>'Aceptado']);
             }
          
            //Lo siguiente será crear el traslado es decir actualizaremos el stock del emisor  :v
            # W O R D S - Sub Español (Anime)
            #para ello verificamos donde estamos y quien es el emisor aaa
             $idsucursal=Auth::user()->id_s;
             $buscar2=DB::table('detalle_pedido as dt')
             ->where('dt.idnotificacion_pedido','=',$id)
             ->get();

             if($idsucursal=='3'){

                  //estoy en almacen, entonces solo cambio el estado... ya q es como si yo hiciese la compra y ya 
                  // se actualizo el stock con ello.... y solo lo ergistramso con el fin de ver cuanto le ha de pedir
                  // al proveedor un determinado articulo por todos

                   if($id_emi=='3'){//pq hice la compra y evidentemente ya se actualizo mi stok 
                     DB::table('notificacion_pedido as np')
                    ->where('np.idnotificacion_pedido','=', $id)
                    ->update(['np.estado'=>'Aceptado']);
                     
                     Alert::success('El estado del Pedido fue cambiado exitosamente', 'Mensaje del Sistema')->persistent("Close");
                     return Redirect::to('pedidos/proveedor');

                   }else{
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

                    $nuevo_stock=$stock_ant1+$bus2->cant_pp;
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
                    $nuevo_stock2=$stock_ant2-$bus2->cant_pp;
                    //editamos
                     DB::table('detalle_articulo as da')
                    ->where('da.iddetalle_articulo','=',$bus2->idarticulo)
                    ->update(['da.num_stock_gn'=>$nuevo_stock2]);

                    //Agregando Movimiento para mi
                    DB::table('movimiento')->insert(['idarticulo' =>  $bus2->idarticulo, 'tipo_movimiento' => 'Salida' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cant_pp, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$idsucursal,'nota'=>'-']);

                    //Agregando movimiento para él
                   DB::table('movimiento')->insert(['idarticulo' => $bus2->idarticulo, 'tipo_movimiento' => 'Entrada' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cant_pp, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$id_emi,'nota'=>'-']); 
                   
                    DB::table('notificacion_pedido as np')
                    ->where('np.idnotificacion_pedido','=', $id)
                    ->update(['np.estado'=>'Aceptado']);

                   }
                      Alert::success('El traslado fue realizado exitosamente', 'Mensaje del Sistema')->persistent("Close");
                     return Redirect::to('pedidos/proveedor');    
               }

             }else{
                //estoy en sucursal .... , hay q ver quien es el emisor que quiere el pedido

                 if($id_emi==3){
                    //entonces resto mi stock de sucursal y actualizo el stock de almacen

                        foreach ($buscar2 as $bus2) {
        

                            $stock_ant=DB::table('detalle_articulo as da')
                            ->select('da.num_stock_gn')
                            ->where('da.iddetalle_articulo','=',$bus2->idarticulo)
                            ->get();

                            foreach ($stock_ant as $key ) {
                              $stock_ant1=$key->num_stock_gn;
                            }

                            $nuevo_stock=$stock_ant1+$bus2->cant_pp;
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
                            $nuevo_stock2=$stock_ant2-$bus2->cant_pp;
                            //editamos
                             DB::table('traslado as tr')
                            ->where('tr.idtraslado','=',$id_tr)
                            ->update(['tr.stock'=>$nuevo_stock2]); 

                            //Agregando Movimiento para mi
                              DB::table('movimiento')->insert(['idarticulo' =>  $bus2->idarticulo, 'tipo_movimiento' => 'Salida' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cant_pp, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$idsucursal,'nota'=>'-']);

                            //Agregando movimiento para él
                              DB::table('movimiento')->insert(['idarticulo' => $bus2->idarticulo, 'tipo_movimiento' => 'Entrada' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cant_pp, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$id_emi,'nota'=>'-']); 

                            DB::table('notificacion_pedido as np')
                            ->where('np.idnotificacion_pedido','=', $id)
                            ->update(['np.estado'=>'Aceptado']);

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

                            $nuevo_stock=$stock_ant1+$bus2->cant_pp;
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
                            $nuevo_stock2=$stock_ant2-$bus2->cant_pp;
                            //editamos
                             DB::table('traslado as tr')
                            ->where('tr.idtraslado','=',$id_tr)
                            ->update(['tr.stock'=>$nuevo_stock2]);

                              //Agregando Movimiento para mi
                              DB::table('movimiento')->insert(['idarticulo' =>  $bus2->idarticulo, 'tipo_movimiento' => 'Salida' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cant_pp, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$idsucursal,'nota'=>'-']);

                            //Agregando movimiento para él
                              DB::table('movimiento')->insert(['idarticulo' => $bus2->idarticulo, 'tipo_movimiento' => 'Entrada' ,'motivo' => 'Traslado', 'cantidad' => $bus2->cant_pp, 'estado' => 'Activo' , 'fecha_mov' => $mytime->toDateTimeString(),'idsucursal' =>$id_emi,'nota'=>'-']); 

                              DB::table('notificacion_pedido as np')
                              ->where('np.idnotificacion_pedido','=', $id)
                              ->update(['np.estado'=>'Aceptado']);

                      }
                 }


         Alert::success('El traslado fue realizado exitosamente', 'Mensaje del Sistema')->persistent("Close");
         return Redirect::to('pedidos/proveedor');    
             
        }
# 

  }

}
