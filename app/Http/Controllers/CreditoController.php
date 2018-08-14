<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\CreditoFormRequest;
use sisVentas\Credito;
use DB;
use sisVentas\Detalle_Credito;
use Auth;
use Session;
use Alert;
use Fpdf;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class CreditoController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
   {
     $sucursal=Auth::user()->id_s;
     $detalles=DB::table('detalle_credito')
     ->get();

      $pfechas=DB::table('detalle_fecha_cre')
     ->get();

     $creditos=DB::table('credito as c')
    ->join('venta as v','v.idventa','=','c.idventa')
    ->join('persona as p','v.idcliente','=','p.idpersona')
    ->select('c.idcredito','v.serie_comprobante','v.num_comprobante','v.idventa','p.nombre','p.telefono','c.total','c.cant_letras','c.estado','c.resto','c.fecha_px')
    ->where('c.idsucursal',$sucursal)
    ->get();
      return view('ventas.credito.index',["creditos"=>$creditos,"detalles"=>$detalles,"pfechas"=>$pfechas]);
   }

   public function create()
  {
    return view("ventas.credito.plus");
  }


  public function store (CreditoFormRequest $request)
  {
      //PARA DETALLE CREDITO


      $cre=new Detalle_Credito;
      $cre->monto=$request->get('monto');
      $cre->idcredito=$request->get('idcre');
      $mytime = Carbon::now('America/Lima');
      $cre->fecha_pago=$mytime->toDateTimeString();
      $cre->save();


     //PARA CREDIT

      $total=$request->get('total');
      $idi=$request->get('idi');
      $cre_actual=$request->get('idcre');
      $mon=$request->get('monto');
      $restopre=$request->get('resto');

      $resto= $restopre-$mon; //AHORA ELLO HAY QUE ACTUALIZAR

      if($resto==0){
          //modificamos el estado de
         DB::table('venta as v')
         ->where('v.idventa', $idi)
         ->update(['v.estado' =>'Pagado']);


         $credito_g=Credito::findOrFail($cre_actual);
         $credito_g->fecha_px='0000-00-00';
         $credito_g->resto= $resto;
         $credito_g->estado= 'Pagado';
         $credito_g->update();

           Alert::success('El crédito termino de pagarse exitosamente', 'Mensaje del Sistema')->persistent("Close");
           return Redirect::to('ventas/credito');

      }else{
        //esto ahora lo veo 
        $credito_g=Credito::findOrFail($cre_actual);
        //TOP DE LA SIGUIENTE FECHA :V 

           $fir=DB::table('detalle_fecha_cre')
            ->select( 'fecha')
            ->where('idcredito', $cre_actual)
            ->whereRaw('fecha > now()')
            ->orderBy('fecha','asc')
            ->first(); //obtiene la fecha mas cercana a la de hoy para q asi se actualize la fecha_prox de credito :v
            $tam=count($fir);
           if($tam==0){

              Alert::error('Agregue una proxima fecha', 'Mensaje del Sistema')->persistent("Close");
              return Redirect::to('ventas/credito');

           }else{
                    
                   
                      $credito_g->fecha_px=$fir->fecha;
                      $credito_g->resto= $resto;
                      $credito_g->update();

                       Alert::success('El nuevo monto se agregó correctamente', 'Mensaje del Sistema')->persistent("Close");
                        return Redirect::to('ventas/credito');
                    
           }

     
      }



     

  }
  public function edit($id)
  {
      return view("ventas.credito.edit");
  }

  public function update(CreditoFormRequest $request,$id)
  {
      $credito_p=Credito::findOrFail($id);
      $credito_p->cant_letras=$request->get('letras');
      $credito_p->fecha_px=$request->get('fecha_px');
      $credito_p->update();
      Alert::success('El crédito  se editó correctamente', 'Mensaje del Sistema')->persistent("Close");
      return Redirect::to('ventas/credito');
  }

  public function destroy($id)
  {
      $credito_p=Credito::findOrFail($id);
      $credito_p->estado='Anulado';
      $credito_p->update();
      Alert::success('El crédito se ha anulado correctamente', 'Mensaje del Sistema')->persistent("Close");
      return Redirect::to('ventas/credito');
  }


}

