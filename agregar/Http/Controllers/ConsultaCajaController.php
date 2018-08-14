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

class ConsultaCajaController extends Controller
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
    		->where('idsucursal','=',$sucursal)
    		->get();



    return view('consultacaja.index',["caja"=>$caja]);
    }

    public function show($id){
    	  $detalles=DB::table('detalle_caja')
          ->where('idcaja','=',$id)
          ->get();

           return view("consultacaja.show",["detalles"=>$detalles]);
    }



    public function destroy($id)
  {
       $mytime = Carbon::now('America/Lima');
    		 $caja=Caja::findOrFail($id);
             $caja->estado='cerrado';
             $caja->hora_cierre=$mytime->toTimeString();
             $caja->update();
      Alert::success('La caja se ha cerrado correctamente', 'Mensaje del Sistema')->persistent("Close");
      return Redirect::to('consultacaja');
  }

}
