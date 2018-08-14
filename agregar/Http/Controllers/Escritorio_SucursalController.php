<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;

use DB;
use Auth;
use Alert;
use Carbon\Carbon;
use Response;

class Escritorio_SucursalController extends Controller
{
  public function __construct()
 {
     $this->middleware('auth');
 }
 public function index()
 {
 			   $s_ac=Auth::user()->id_s;
 		 /*detalles de los articulos con stock por debajo del minimo
          $detalles=DB::table('detalle_articulo as da')
          ->join('articulo as art','art.idarticulo','=','da.idarticulo')
          ->select(DB::raw('CONCAT(art.nombre, " color ",da.etiqueta,"/",da.tam_nro1,da.UN1,"-",da.tam_nro2,da.UN2) AS articulo_com'),'da.iddetalle_articulo','da.imagen','da.stockmin','da.medida_stock_gn','da.num_stock_gn','da.medida_stock_det','da.num_stock_det')
          ->get();*/

                $detalles=DB::table('traslado as t')
                ->join('detalle_articulo as da','da.iddetalle_articulo','=','t.idarticulo')
                ->join('articulo as art','art.idarticulo','=','da.idarticulo')
                ->select(DB::raw('CONCAT(art.nombre, " color ",da.etiqueta,"/",da.tam_nro1,da.UN1,"-",da.tam_nro2,da.UN2) AS articulo_com'),'da.iddetalle_articulo','da.imagen','t.stock','t.stockmin', 't.cantidad_detalle','da.medida_stock_det','da.medida_stock_gn')
                ->where('t.idsucursal','=',$s_ac)
                ->get();


       

          $total_pro=DB::table('persona')
          ->where('tipo_persona','=','Cliente')
          ->where('estado','=','Activo')
          ->where('idsucursal','=',$s_ac)
          ->count();
          //utilizaremos ello para mostrar el reporte grafico
          $comprasmes=DB::select('SELECT monthname(v.fecha_hora) as mes, sum(v.total_venta) as totalmes from venta v where v.estado="Aceptado" or v.estado="Pagado" group by monthname(v.fecha_hora) order by month(v.fecha_hora) asc limit 12');

          //esto es para las compras del dia de hoy
          $comprashoy=DB::select('SELECT sum(v.total_venta) as totaldia from venta v where (v.estado="Aceptado" or v.estado="Pagado") and (v.fecha_hora=CURRENT_DATE())');



          //esto es para ver las comprasen los ultimos 15 diass
          $comprasdias=DB::select('SELECT DATE(v.fecha_hora) as dia, sum(v.total_venta) as totaldia from venta v where (v.estado="Aceptado" or v.estado="Pagado") group by v.fecha_hora order by day(v.fecha_hora) desc limit 14');

          $proveedores = DB::table('detalle_proveedor as dp')
         ->join('persona as per','per.idpersona','=','dp.idproveedor')
         ->select('per.nombre','dp.idarticulo','per.email','per.telefono')
         ->where('per.tipo_persona','=','Proveedor')
         ->get();


         $anuladas=DB::table('venta as v')->where('v.estado','=','Anulado')->where('v.idsucursal','=',$s_ac)->count();
         $aceptadas=DB::table('venta as v')->where('v.estado','=','Aceptado')->where('v.idsucursal','=',$s_ac)->count();
         $faltantes=DB::table('venta as v')->where('v.estado','=','Por Pagar')->where('v.idsucursal','=',$s_ac)->count();
         $pagadas=DB::table('venta as v')->where('v.estado','=','Pagado')->where('v.idsucursal','=',$s_ac)->count();
         
         	//corregir 
         $mascomprado=DB::select('SELECT a.nombre as articulo,da.UN1,da.UN2,da.tam_nro2,da.tam_nro1,da.etiqueta as color,sum(di.cantidad_detalle) as cantidad from articulo a inner join detalle_articulo da on a.idarticulo=da.idarticulo inner join detalle_ingreso di on da.iddetalle_articulo=di.idarticulo inner join ingreso i on i.idingreso=di.idingreso where (i.estado="Aceptado" or i.estado="Pagado") and year(i.fecha_hora)=year(curdate()) group by da.etiqueta order by sum(di.cantidad_detalle) desc limit 8');

          /* $articulos = DB::table('detalle_articulo as da')
            ->join('articulo as art','art.idarticulo','=','da.idarticulo')
            ->select(DB::raw('CONCAT(art.nombre, " color ",da.etiqueta) AS articulo'),'da.UN1','da.UN2','da.tam_nro1','da.tam_nro2','da.precio_normal_u','da.imagen')
            ->orderBy('da.iddetalle_articulo','desc')            
            ->take(4)
            ->get();*/

            $articulos= DB::table('traslado as t')
                ->join('detalle_articulo as da','da.iddetalle_articulo','=','t.idarticulo')
                ->join('articulo as art','art.idarticulo','=','da.idarticulo')
                ->select(DB::raw('CONCAT(art.nombre, " color ",da.etiqueta) AS articulo'),'da.iddetalle_articulo','da.UN1','da.UN2','da.tam_nro1','da.tam_nro2','t.stock','da.imagen','t.precio_venta')
                ->where('t.idsucursal','=',$s_ac)
                 ->take(4)
                ->get();

        return view('escritorio_suc',["anuladas"=>$anuladas,"aceptadas"=>$aceptadas,"faltantes"=>$faltantes,"pagadas"=>$pagadas,"mascomprado"=>$mascomprado,"comprasdias"=>$comprasdias,"comprasmes"=>$comprasmes,"detalles"=>$detalles,"proveedores"=>$proveedores,"total1"=>$total_pro,"comprashoy"=>$comprashoy,"articulos"=>$articulos]);


 	  
    // return view('escritorio_suc',[]);
 }
}
