<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests;
use DB;
use Fpdf;
use Alert;
use Carbon\Carbon;
use Response;
use sisVentas\Http\Requests\FormRequestCaja;
use sisVentas\Caja;
use sisVentas\DetalleCaja;
use Auth;

class CajaController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    		$sucursal=Auth::user()->id_s;
    		$mytime2 = Carbon::now('America/Lima');
    		$fecha = $mytime2->toDateTimeString();
    		$fecha2 = $mytime2->toDateString();
    		$caja=DB::table('caja')
    		->select(DB::raw('SUM(monto_cierre) as total'),'idcaja','fecha','monto_aper','estado')
    		->where('idsucursal','=',$sucursal)
    		->where('fecha','=',$fecha2)
    		->get();

    		foreach ($caja as $key) {
    			$id=$key->idcaja;
                $mostrar=$key->total;
                $apert=$key->monto_aper;
                $estado=$key->estado;
    		}

            $detalles=DB::table('detalle_caja as dc')
            ->join('caja as c','c.idcaja','=','dc.idcaja')
            ->where('c.idsucursal',$sucursal)
            ->where('c.fecha',$fecha2)
            ->get();




                $number=DB::table('caja')
                ->select(DB::raw('MAX(idcaja) as g'))
                ->where('idsucursal',$sucursal)
                ->get();

               foreach ($number as $nu ) {
                      $keynew=$nu->g;
                    }
         

                $ultim=DB::table('caja as cj')
                ->where('cj.idcaja',$keynew)
                ->get();



    return view('caja.index',["fecha"=>$fecha,"mostrar"=>$mostrar,"id"=>$id,"detalles"=>$detalles,"apert"=>$apert,"caja"=>$caja,"estado"=>$estado,"ultim"=>$ultim]);


    }
     public function create()
    {
    	 return view("caja.create"); //validar q el anterior este cerrado :'v
    }

      public function store(FormRequestCaja $request)
    {
    	$sucursal=Auth::user()->id_s;

    	$mytime2 = Carbon::now('America/Lima');
    	$fecha = $mytime2->toDateTimeString();
    	$ayer=$request->get('ayer');
        $idayer=$request->get('id_ayer');
        $retirar=$request->get('monto_a');
        if($ayer=='1'){
            //descontamos de detalles de ayer; aumentamos una transaccion 

                    $caja_det=new DetalleCaja;
                    $caja_det->idcaja=$idayer;
                    $caja_det->descripcion='Retiro para la apertura de la siguiente caja';
                    $caja_det->hora=$mytime2->toTimeString();
                    $caja_det->monto= $retirar;
                    $caja_det->tipo='Salida';
                    $caja_det->save();

                    //actualizamos el monto de cierre de ayer
                       $anterior=DB::table('caja')
                        ->select('monto_cierre')
                        ->where('idcaja',$idayer)
                        ->get();

                    foreach ($anterior as $key ) {
                            $edit=$key->monto_cierre;
                        } 

                        //restamos por ser retiro

                      $actual_m=$edit-$retirar;

                      $caja=Caja::findOrFail($idayer);
                      $caja->monto_cierre=$actual_m;
                      $caja->update();


                      //ahora de la caja de hoy es abajo


        }else{
           //nada pq es nuevo :v 
        }

            $caja=new Caja;
            $caja->monto_aper=$request->get('monto_a');
            $caja->monto_cierre=$request->get('monto_a');
            $caja->fecha=$fecha;
            $caja->hora_cierre='00:00:00';
            $caja->hora_apertura=$mytime2->toTimeString();
            $caja->idsucursal=$sucursal;
            $caja->estado='abierto';
            $caja->save();


            $caja_det=new DetalleCaja;
            $caja_det->idcaja=$caja->idcaja;
            $caja_det->descripcion='Apertura';
            $caja_det->hora=$mytime2->toTimeString();
            $caja_det->monto= $caja->monto_cierre;
            $caja_det->tipo='Entrada';
            $caja_det->save();




           Alert::success('La caja se aperturó de manera correcta', 'Mensaje del Sistema')->persistent("Close");
        return Redirect::to('caja');
    }

    public function edit($id)
    {
        return view("caja.edit",["caja"=>Caja::findOrFail($id)]);
    }
    public function update(FormRequestCaja $request,$id)
    {
        $estado=$request->get('estado');
        $rea=$request->get('rea');
        if($estado=='cerrado'){

            if($rea=='1'){
                //lo reaperturamos :v 
                      $caja=Caja::findOrFail($id);
                      $caja->estado='abierto';
                       $caja->update();
                Alert::success('La Caja se reaperturó manera exitosa', 'Mensaje del Sistema')->persistent("Close");
                return Redirect::to('caja');

            }else{

                Alert::warning('La Caja ya se encuentra cerrada, si desea puede reaperturarla', 'Mensaje del Sistema')->persistent("Close");
                return Redirect::to('caja');

            }
                 

        }else{

                $mytime = Carbon::now('America/Lima');
                $caja=Caja::findOrFail($id);
                $caja->estado='cerrado';
                $caja->hora_cierre=$mytime->toTimeString();
                $caja->update();
                Alert::success('La Caja de hoy se cerro de manera exitosa', 'Mensaje del Sistema')->persistent("Close");
                return Redirect::to('caja');

        }
       
    }

}


