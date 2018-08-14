<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests; 
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\FechaFormRequest;
use sisVentas\Detalle_fecha_cre;
use DB;

use Session;
use Alert;
use Fpdf;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class FechaController extends Controller
{
      public function create()
  {
    return view("ventas.credito.plusfecha");
  }
   public function store (FechaFormRequest $request)
  {
  		  $cre=new Detalle_fecha_cre;
	      $cre->idcredito=$request->get('idcre2');
	      $mytime = Carbon::now('America/Lima');
	      $cre->fecha=$request->get('fecha_px');
	      $cre->save();

	      Alert::success('La nueva fecha se agregó correctamente', 'Mensaje del Sistema')->persistent("Close");
      return Redirect::to('ventas/credito');
  }
}
