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
use sisVentas\DetalleCaja;
use Auth;

class DetalleCajaController extends Controller
{


	  public function create()
    {
    	 return view("caja.plus");
    }

      public function store(FormRequestCaja $request)
    {
    	$sucursal=Auth::user()->id_s;
    	$tip=$request->get('radio');
    	$id_c=$request->get('id_cj');
    	$mytime2 = Carbon::now('America/Lima');
    	
        $caja_det=new DetalleCaja;
        $caja_det->idcaja=$request->get('id_cj');
        $caja_det->descripcion=$request->get('descripcion');
        $caja_det->hora=$mytime2->toTimeString();
        $caja_det->monto=$request->get('dinero');
        $caja_det->tipo=$request->get('radio');
        $caja_det->save();
        //buscamos el ultimo registro con el idcaja
        $anterior=DB::table('caja')
        	->select('monto_cierre')
        	->where('idcaja',$id_c)
        	->get();

        foreach ($anterior as $key ) {
        		$edit=$key->monto_cierre;
        	}

        if($tip=='Entrada'){
       
             	$actual=$edit +  $caja_det->monto;
        }else{

        		$actual=$edit -  $caja_det->monto;

        }

        //ahora el update :'v

            DB::table('caja')
              ->where('idcaja', $id_c)
              ->update(['monto_cierre'=>$actual]);

           Alert::success('La caja se actualizó correctamente', 'Mensaje del Sistema')->persistent("Close");
        
        return Redirect::to('caja');
    }

    
}
