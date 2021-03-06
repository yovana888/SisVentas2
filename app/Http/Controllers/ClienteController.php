<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;
use sisVentas\Persona;
use sisVentas\Articulo;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\PersonaFormRequest;
use DB;
use Auth;
use Alert;
use Input;
use Fpdf;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index(Request $request)
    {
            $s_ac=Auth::user()->id_s;
            $personas=DB::table('persona')
            ->where ('tipo_persona','=','Cliente')
            ->where ('idsucursal','=', $s_ac)
            ->orderBy('idpersona','desc')
            ->get();



            return view('ventas.cliente.index',["personas"=>$personas]);

    }
    public function create()
    {
        return view("ventas.cliente.create");
    }
    public function store (PersonaFormRequest $request)
    {
        $persona=new Persona;
        $s_act=Auth::user()->id_s;
        $persona->idsucursal=$s_act;
        $persona->tipo_persona='Cliente';
        $persona->nombre=$request->get('nombre');
        $persona->num_documento=$request->get('num_documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->ruc=$request->get('ruc');
        $persona->estado="Activo";
        $persona->cuenta=$request->get('cuenta');
        $persona->save();
        Alert::success('El Cliente se registro correctamente', 'Mensaje del Sistema')->persistent("Close");
        return Redirect::to('ventas/cliente');

    }
    public function show($id)
    {
        return view("ventas.cliente.show",["persona"=>Persona::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("ventas.cliente.edit",["persona"=>Persona::findOrFail($id)]);
    }
    public function update(PersonaFormRequest $request,$id)
    {
       
        $persona=Persona::findOrFail($id);
        $s_act=Auth::user()->id_s;
        $persona->idsucursal=$s_act;
        $persona->tipo_persona='Cliente';
        $persona->nombre=$request->get('nombre');
        $persona->num_documento=$request->get('num_documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->ruc=$request->get('ruc');
        $persona->cuenta=$request->get('cuenta');
        $persona->estado=$request->get('estado');
        Alert::success('El Cliente se editó correctamente', 'Mensaje del Sistema')->persistent("Close");
        $persona->update();
        return Redirect::to('ventas/cliente');

    }
    public function destroy($id)
    {
        $persona=Persona::findOrFail($id);
        $persona->delete();
         Alert::success('Cliente eliminado correctamente', 'Mensaje del Sistema')->persistent("Close");
        return Redirect::to('ventas/cliente');
    }

    public function reporte(){

        //  @include('compras.proveedor.plus',[$per->nombre,$detalles,$articulos])      modal-ag-{{$per->idpersona}}
      /*  $articulos = DB::table('articulo as art')
        ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'art.idarticulo')
        ->where('art.estado','=','Activo')
        ->get();

         $detalles = DB::table('detalle_proveedor as dp')
        ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
        ->select('dp.iddetalle_proveedor','a.nombre','dp.idproveedor')
        ->where('a.estado','=','Activo')
        ->get();*/
         //Obtenemos los registros
         $registros=DB::table('persona')
            ->where ('tipo_persona','=','Proveedor')
            ->orderBy('idpersona','desc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado Proveedores"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda
         $pdf::SetFont('Arial','B',10);
         //El ancho de las columnas debe de sumar promedio 190
         $pdf::cell(80,8,utf8_decode("Nombre"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Documento"),1,"","L",true);
         $pdf::cell(50,8,utf8_decode("Email"),1,"","L",true);
         $pdf::cell(25,8,utf8_decode("Teléfono"),1,"","L",true);

         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);

         foreach ($registros as $reg)
         {
            $pdf::cell(80,6,utf8_decode($reg->nombre),1,"","L",true);
            $pdf::cell(35,6,utf8_decode($reg->num_documento),1,"","L",true);
            $pdf::cell(50,6,utf8_decode($reg->email),1,"","L",true);
            $pdf::cell(25,6,utf8_decode($reg->telefono),1,"","L",true);
            $pdf::Ln();
         }

         $pdf::Output();
         exit;
    }
}
