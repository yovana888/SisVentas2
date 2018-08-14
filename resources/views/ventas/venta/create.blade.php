
<style type="text/css">

.notify {
    position: fixed;
    z-index: 99999999;
    width: 220px;
    left: 30px;
    bottom: 30px;
}
.notify .alert{
    box-shadow: 0px 2px 5px -1px #000;
   display: none;
}

/*Galeria */
ul.galeria2{
width:100%;
margin:10px 5px;
padding:0}
ul.galeria2 li{
height:90px; /*alto de la image*/
width:90px; /*el mismo ancho que la imagen*/
display:block;
margin:0 3px 5px 0; /* separación de cada elemento*/
padding:0;
float:left;
list-style:none;
position:relative;
overflow:hidden;}

ul.galeria2 a{
background:none;
margin:0;
padding:0;
color:#fff;
text-align:center;
white-space:nowrap;}
ul.galeria2 li img{ width:90px; /*ancho de la imagen*/ height:90px; /*alto de la imagen*/
margin:0; 
padding:0;
border:none;
}
ul.galeria2 span{
margin:0;
width:90px; /*el mismo ancho de la imagen*/
left:1px; /*el mismo ancho que el borde*/ 
padding:3px 0 3px 0;
background:#000;
bottom:-8px;
left:0px; filter:alpha(opacity=0);
opacity:0;
overflow:hidden;
cursor:pointer; position:absolute;
-webkit-transition:all .25s ease; -moz-transition:all .25s ease; -o-transition:all .25s ease; transition:all .25s ease;
}

ul.galeria2 label{
margin:0;
width:90px; /*el mismo ancho de la imagen*/
left:1px; /*el mismo ancho que el borde*/ 
padding:3px 0 3px 0;
background:none;
bottom:-8px;
left:0px; filter:alpha(opacity=0);
opacity:0;
overflow:hidden;
cursor:pointer; position:absolute;
-webkit-transition:all .25s ease; -moz-transition:all .25s ease; -o-transition:all .25s ease; transition:all .25s ease;
}

ul.galeria2 a:hover label{ left:-18; bottom:66; opacity:.9;filter:alpha(opacity=90)}
ul.galeria2 a label:hover{color:#cec20b} /*color fuente al poner el puntero encima*/
/*Navegacion CSS*/
.holder {
margin: 15px 0;
}


ul.galeria2 a:hover span{ left:0; bottom:0; opacity:.9;filter:alpha(opacity=90)}
ul.galeria2 a span:hover{color:#cec20b} /*color fuente al poner el puntero encima*/
/*Navegacion CSS*/
.holder {
margin: 15px 0;
}
.holder a {
font-size: 12px;
cursor: pointer;
margin: 0 5px;
color: #333;
}
.holder a:hover {
background-color: #222;
color: #fff;
}
.holder a.jp-previous { margin-right: 15px; }
.holder a.jp-next { margin-left: 15px; }
.holder a.jp-current, a.jp-current:hover {
color: #FF4242;
font-weight: bold;
}
.holder a.jp-disabled, a.jp-disabled:hover {
color: #bbb;
}
.holder a.jp-current, a.jp-current:hover,
.holder a.jp-disabled, a.jp-disabled:hover {
cursor: default;
background: none;
}
.holder span { margin: 0 5px; }
</style>

<style type="text/css">
/*Animate.css - http://daneden.me/animateLICENSED UNDER THE MIT LICENSE (MIT)Copyright (c) 2011 Dan Eden*/ .animated{-webkit-animation-fill-mode:both;-moz-animation-fill-mode:both;-ms-animation-fill-mode:both;-o-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation-duration:1s;-moz-animation-duration:1s;-ms-animation-duration:1s;-o-animation-duration:1s;animation-duration:1s}
.animated.hinge{-webkit-animation-duration:2s; -moz-animation-duration:2s; -ms-animation-duration:2s; -o-animation-duration:2s; animation-duration:2s}
@-webkit-keyframes bounceIn{0%{opacity:0;-webkit-transform:scale(.3)}50%{opacity:1;-webkit-transform:scale(1.05)}70%{-webkit-transform:scale(.9)}100%{-webkit-transform:scale(1)}}@-moz-keyframes bounceIn{0%{opacity:0;-moz-transform:scale(.3)}50%{opacity:1;-moz-transform:scale(1.05)}70%{-moz-transform:scale(.9)}100%{-moz-transform:scale(1)}}@-o-keyframes bounceIn{0%{opacity:0;-o-transform:scale(.3)}50%{opacity:1;-o-transform:scale(1.05)}70%{-o-transform:scale(.9)}100%{-o-transform:scale(1)}}@keyframes bounceIn{0%{opacity:0;transform:scale(.3)}50%{opacity:1;transform:scale(1.05)}70%{transform:scale(.9)}100%{transform:scale(1)}}.bounceIn{-webkit-animation-name:bounceIn;-moz-animation-name:bounceIn;-o-animation-name:bounceIn;animation-name:bounceIn;}
</style>

@extends ('layouts.admin')
@section ('contenido')
<div class="profile-header" id="rem2">

<div class="profile-header-cover" ></div>

<div class="profile-header-content">

  <div class="profile-header-info">

    <h4>Sistema de Gestión de Inventario</h4>

      <a href="#" class="btn btn-xs" style="background:#bd6eca; color:#fff;">{{Auth::user()->s_actual}} / {{Auth::user()->rol_actual}}</a>

  </div>

</div>

</div>

<br>
<ul class="breadcrumb " style="margin-left: 3%; ">
     <span style="color:#311b92; font-weight: bold; font-size: 12px;" >TICKET-BOLETA:{{$num_s}}-{{$correlativo}}</span>

  </ul>
  <div class="panel panel-default " style="margin-left: 3%; margin-right :3%;" id="rem1">

{!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
{{Form::token()}}
<div class="panel-heading" style="">
        <div class="panel-heading-btn" >
            <div class="dropdown dropdown-icon">
                    <a href="javascript:;" class="btn" data-toggle="dropdown"><i class="glyphicon glyphicon-option-vertical"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#">IMPORT</a></li>
                        <li><a href="#">EXPORT</a></li>
                        <li class="divider"></li>
                        <li><a href="#">SETTINGS</a></li>
                    </ul>
                </div>
                <a href="javascript:;" class="btn" data-toggle="panel-expand"><i class="glyphicon glyphicon-resize-full"></i></a>
                <a href="javascript:;" class="btn" data-toggle="panel-reload"><i class="glyphicon glyphicon-repeat"></i></a>
                <a href="javascript:;" class="btn" data-toggle="panel-collapse"><i class="glyphicon glyphicon-chevron-up"></i></a>
                <a href="javascript:;" class="btn" data-toggle="panel-remove"><i class="glyphicon glyphicon-remove"></i></a>

        </div>

</div>

<div class="panel-body">

 
<div class="row" style="padding: 12px 7px;">
    <div class="col-md-7"  style="padding: 4px 3px; ">
        <div class="row">
           <div class="col-md-12">
               <div class="input-group">
                                 <span class="input-group-btn">
                                       <button class=" btn btn" type="button" style="background-color: #c0c1d6; color: #fff; border-radius: 0px;height: 34px;"><i class="ti-plus"></i></button>
                                  </span>

                                  <span class="input-group-btn">
                                       <button class=" btn btn" type="button" style="background: #c0c1d6;  height: 34px; color:#fff;border-radius: 0px;"><i class="ti-reload" ></i></button>
                                  </span>
                            
                                 <select name="idcliente" id="idproveedor" class="form-control selectpicker selection" data-live-search="true" required style="height: 12px;">
                                                 <!--Poner por defecto en si general-->
                                                    @foreach($personas as $persona)
                                                     <option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
                                                    @endforeach
                                </select>
                </div>
           </div>
        </div>
    <br>
    <div class="row">
        <div class="col-md-2">
            <input type="number" id="can" class="form-control" value="1">
        </div>
        <div class="col-md-6">
           <button class="btn btn pull-left m-l-5" style="background:#bd6eca; color:#fff;" value="" disabled  id="btn_u" type="button">S/. 0 -> c/u</button>
             <button class="btn btn pull-left m-l-5" value="" disabled id="btn_d" type="button" style="background: #c0c1d6; color: #fff;"  >S/. 0 -> m</button>
        </div>
        <div class="col-md-3">
               <label class="text-pink" id="actual">* </label>
        </div>
    </div>
      <br>
        <div class="row">
            <div class="col-md-12">
                
                <div class="table-responsive">
                            <table class="table " id="detalles">
                                <thead style="color:#888;">
                                    <th></th>
                                    <th>Artículo</th>
                                    <th>Cant.</th>
                                    <th>Precio U.</th>
                                    <th>Desc.</th>
                                    <th>Importe</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                </div>
            </div>
        </div>

         <div class="row">
                            <div class="col-md-2">
                                <label style="color:#888; font-weight: bold; font-size: 18px;">TOTAL</label>
                            </div>
                            <div class="col-md-4">
                                <span class="text-pink" style=" font-size: 18px; font-weight: bold;" id="total">S/. 0</span>
                            </div>
          </div>

          
          <br>
          <div class="row">
                <div class="col-md-2 col-xs-4">
                    <button class="btn btn" type="button" data-toggle="modal" data-target="#pagando" style="background: #6ec89b; color: #fff;"> <i class="ti-receipt" ></i>Pagar</button>
                   
                </div>
                 <div class="col-md-2 col-xs-4">
                    <button class="btn btn-default" style=" margin-left:10px; color: #888;"> <i class="ti-close"></i> Cancelar</button>     
                </div>
          </div>
       
    </div>
    <div class="col-md-5"  style="padding: 4px 12px;">
       <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                         <div class="input-group">
                                 <span class="input-group-btn">
                                       <button class=" btn btn" type="button" style="height:34px; background:#bd6eca; color:#fff;"><i class="ti-search"></i></button>
                                  </span>
                                 <input type="text" id="fil"  placeholder="Codigo/Nombre/Subcategoría" class="form-control">
                                  
                        </div>
                    </div>
                </div>
                <div class="row">
                       <div class="" >
                           <div class="holder"></div>
                          
                               <ul class="galeria2" id="itemContainer" >
                                    @foreach ($articulos as $art)
                                    <li data-toggle="tooltip" title="{{$art->articulo}} / {{$art->tam_nro1}} {{$art->UN1}} - {{$art->tam_nro2}} {{$art->UN2}}" id="{{$art->articulo}}">
                                    <a href="#" value="{{$art->idtraslado}}" id="enl_{{$art->idtraslado}}" onclick="fnProcesa(this)">                                           
                                             @if($art->imagen=='')
                                             <img src="{{asset('imagenes/variaciones/nofoto.jpg')}}" class="img-thumbnail"/>
                                            @else
                                             <img src="{{asset('imagenes/variaciones/'.$art->imagen)}}" class="img-thumbnail"/>
                                            @endif    
                                        </a>
                                    </li>   

                                    <input type="text" id="st_{{$art->idtraslado}}" value="{{$art->stock}}" hidden="hidden">

                                    <input type="text" id="nom_{{$art->idtraslado}}" value="{{$art->articulo}} / {{$art->tam_nro1}} {{$art->UN1}} - {{$art->tam_nro2}} {{$art->UN2}}" hidden="hidden">
                                    <input type="text" id="sd_{{$art->idtraslado}}" value="{{$art->cantidad_detalle}}" hidden="hidden">

                                    <input type="text" id="pu_{{$art->idtraslado}}" value="{{$art->precio_venta}}" hidden="hidden">  
                                    <input type="text" id="pd_{{$art->idtraslado}}" value="{{$art->precio_detalle}}" hidden="hidden">

                                     <input type="text" id="t2_{{$art->idtraslado}}" value="{{$art->medida_stock_det}}" hidden="hidden">
                                     <input type="text" id="t1_{{$art->idtraslado}}" value="{{$art->medida_stock_gn}}" hidden="hidden"> 
                                      <input type="text" id="lon_{{$art->idtraslado}}" value="{{$art->tam_nro2}}" hidden="hidden"> 
                                    @endforeach
                               </ul>
                           

                        </div>
                        <input type="text" name="" id="id_tra" hidden="hidden">
                        <input type="text" name="tot" id="tot" hidden="hidden">
                        <input type="text" name="" id="contador_g" hidden="hidden" value="0">
                        <input type="text" name="adios" id="adios"  hidden="hidden" value="0">
                        <input type="text" name="deuda" id="deuda"  hidden="hidden" value="0">
                </div>
             </div>
    </div>
</div>

</div>
</div>


<!--MODAL -->
<div class="modal fade" id="pagando" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span id="msm" class="label label-success" style="font-size: 15px;color:#fff; font-weight: bold;">S/.0</span><span style="color:#311b92; font-weight: bold;" > TICKET-BOLETA: {{$num_s}}-{{$correlativo}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="nombre" style="color:#888;">Descuento Global</label>
                            <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1">%</span>
                              <input type="number" style="color:#888;" class="form-control" name="des_global"  value="0" id="des_global">
                            </div>
                            
                         </div>
                    </div>
                    

                     <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="nombre" style="color:#888;">Monto Entregado</label>
                            <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1">S/.</span>
                              <input type="number" style="color:#888;" step="any" class="form-control" name="monto" id="monto" value="0">
                                 <span class="input-group-btn">
                                       <button class=" btn btn-purple" id="cambiando" type="button" style="height: 34px;"><i class="ti-shift-right"></i></button>
                                 </span>
                            </div>
                         </div>
                    </div>

                     <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label class="text-pink"  for="nombre" style="color:#888;" id='tx_cambio0'>Cambio</label>
                            <label class="text-pink"  id="tx_cambio">S/. 0</label>
                            <input type="text" name="cambio" id="cambio" hidden="hidden">
                            
                                  <!--EMPLEADOS-->
                                       <select style="margin-top:-10px;" name="idempleado" id="idempleado" class="form-control selectpicker selection" data-live-search="true" required style="height: 12px;">
                                                 <!--Poner por defecto en si general-->
                                                    @foreach($empleados as $emp)
                                                     <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                    @endforeach
                                       </select>


                         </div>
                    </div>

                </div>

                <div class="row">
                     <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6" id="credi" style="display: none;">
                        <div class="form-group">
                            <label for="nombre" style="color:#888;">Fecha Prox. Pago</label>
                              <div class="input-group">
                                <div class="input-group">
                                  <span class="input-group-addon" id="basic-addon1"><i class="ti-calendar"></i></span>
                                  <input type="date" style="color:#888;" class="form-control" name="fecha_px" id="fecha_px">
                                   <span class="input-group-btn">
                                       <button class=" btn btn-purple" id="let" type="button" style="height: 34px;"><i class="ti-plus"></i></button>
                                 </span>
                                </div>
                              </div>
                         </div>
                    </div>

                  
                </div>

                <div id="table_let" class="row" style="display: none;">
                  <div class="col-md-7">
                     <table class="table" id="let_fe">
                    <thead style="color: #888;">
                      <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody style="color: #888;">
                      
                    </tbody>
                  </table>
                  </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6" style="display: none;" id="shin1">
                        <div class="form-group">
                            <label for="nombre" style="color:#888;">Num. Serie</label>
                            <div class="input-group">
                                <div class="input-group">
                                  <span class="input-group-addon" id="basic-addon1">#</span>
                                  <input type="text" style="color:#888;" class="form-control" name="serie"  value="{{$num_s}}" id="serie">
                                </div>
                            </div>
                         </div>
                    </div>

                     <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6" style="display: none;" id="shin2">
                        <div class="form-group">
                            <label for="nombre" style="color:#888;">Num. Correlativo</label>
                            <div class="input-group">
                                <div class="input-group">
                                  <span class="input-group-addon" id="basic-addon1">#</span>
                                  <input type="text" style="color:#888;" class="form-control" name="corre"  value="{{$correlativo}}" id="corre">
                                </div>
                            </div>
                         </div>
                    </div>
                    
                </div>
                
                <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="nombre" style="color:#888;">Nota</label>       
                            <input name="generado" id="generado" type=checkbox value="1">
                              <input type="text" style="color:#888;" class="form-control" name="nota" >
                             </div>
                        </div>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-pink">Guardar</button>
      </div>
    </div>
  </div>
</div>

{!!Form::close()!!}
@push ('scripts')
    <script src="{{asset('assets\plugins\jquery\jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('assets\plugins\form\bootstrap-select\js\bootstrap-select.min.js')}}"></script>
    <script src="{{asset('js\jpage.js')}}"></script>



<script type="text/javascript">
     $(function() {
     $("div.holder").jPages({
      containerID: "itemContainer",
      previous: "← Anterior",
      next: "Siguiente →",
      perPage: 10,
      midRange: 4,
      animation: "bounceIn"
    });
  });

  </script>
<script type="text/javascript">

 $(document).ready(function(){
    $("#fil").keyup(function(){
 
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;
        // Loop through the comment list
        $(".galeria2 li").each(function(){
 
            // If the list item does not contain the text phrase fade it out
            if ($(this).attr('id').search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
 
            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });
 
        // Update the count
        var numberItems = count;
       console.log(numberItems);
    });
});


function fnProcesa(comp){
   let id = comp.id; //el id completo
   var cad_id2= id.substr(4);
    $('#id_tra').val(cad_id2);
    $('#btn_d').prop( "disabled", false);
    $('#btn_u').prop( "disabled", false);
   var precio1=$('#pu_'+cad_id2).val();
   var precio2=$('#pd_'+cad_id2).val();
   var stock_ac=$('#st_'+cad_id2).val();
   var stock_de=$('#sd_'+cad_id2).val();
   var unidad2=$('#t2_'+cad_id2).val();
   var unidad1=$('#t1_'+cad_id2).val();

   $('#btn_u').val(precio1);
   $('#btn_d').val(precio2);
   if(unidad2=='-'){
       var texto=' * ' + stock_ac +' '+ unidad1;
       $('#btn_d').text('S/. --');
       $('#btn_d').prop( "disabled", true);
   }else{
      var texto=' * ' + stock_ac + ' ' + unidad1 + ' con ' + stock_de + ' ' + unidad2;
       $('#btn_d').prop( "disabled", false);
       if(unidad2=='gr'){
                    $('#btn_d').text('S/. '+precio2 +'-> 100 '+unidad2);

       }else{
                   $('#btn_d').text('S/. '+precio2 +'-> 1 '+unidad2);
       }

   }
  
   $('#actual').text(texto);
   $('#btn_u').text('S/. '+precio1+'->c/u');

}
</script>
<script type="text/javascript">
    var total=0;
    var importe_ini=[];
    var id_traa=[];
    var tipo_p=[];
    var cont=$('#contador_g').val();

    $('#btn_u').click(function(){
        //precio normal => AJAX
        var plus_precio1= $('#btn_u').val();
        var plus_can0= $('#can').val();
        var plus_can=  parseFloat(plus_can0);
        var id_t0=$('#id_tra').val();
        var id_t=parseFloat(id_t0);
        var stock_ac0=$('#st_'+id_t).val();
        var stock_ac= parseFloat(stock_ac0);
        if(plus_can=='0' || plus_can==''){
                            swal(
                                  'Mensaje del Sistema',
                                  'Ingrese una cantidad valida',
                                  'error'
                                );
        $('#can').val('');
        }else{ 

            //verificar q lo q pide no sea mayor q el stock actual
            if(plus_can>stock_ac){

                            swal(
                                  'Mensaje del Sistema',
                                  'La cantidad solicitada es mayor a la existente',
                                  'warning'
                                );

            }else{

                //AJAX
                $.get('/ventas/venta/create/'+id_t+'/detalles',function(data){
                        var nombre_ar=$('#nom_'+id_t).val();
                        var id_ar=data[0].idarticulo;
                        var ca1=data[0].cantidad_volumen1;
                        var ca2=data[0].cantidad_volumen2;
                        var ca3=data[0].cantidad_volumen3;
                        //viendo precios 
                        
                        if(plus_can<ca1){
                            console.log('nada');
                            var precio_u=data[0].precio_venta;

                        }else if(plus_can>=ca1 && plus_can<ca2){
                            console.log('d1');
                            var precio_u=data[0].precio_mayor1;

                        }else if(plus_can>=ca2 && plus_can<ca3){
                            console.log('d2');
                             var precio_u=data[0].precio_mayor2;

                        }else{
                            console.log('d3');
                            var precio_u=data[0].precio_mayor3;
                        }


                        ///////////
                        var incre=$('#contador_g').val();
                         cont=parseFloat(incre);
            
                        var importe=plus_can*precio_u;
                        importe_ini[cont]=importe.toFixed(2);

                        console.log('importeu' +importe_ini[cont] +' '+ cont);

                        total=total+ parseFloat(importe);
                         

                        $("#tot").val(parseFloat(total).toFixed(2));


                        id_traa[cont]=$('#id_tra').val();
                        tipo_p[cont]='normal';
                        var descu=0;
                        //AGREGAMOS LA FILA 
                         var fila='<tr style="color:#888;" class="selected" id="fila'+cont+'"><td class="btn-col" style="white-space: nowrap"><a onclick="eliminar('+cont+');" class="btn btn-danger btn-xs"><i class="ti-close"></i></a><a onclick="editar('+cont+');" class="btn btn-warning btn-xs"><i class="ti-reload"></i></a></td><td><input type="hidden" name="idarticulo[]" value="'+id_ar+'">'+nombre_ar+'</td><td class="form-col"><input type="number" class="form-control input-sm" value="'+plus_can+'" name="cantidad_dt[]" id="ctd'+cont+'"></td><td class="form-col"><input type="number" class="form-control input-sm" value="'+precio_u+'" name="precio_unit[]" id="pv'+cont+'"><td class="form-col"><input type="number" class="form-control input-sm" value="0" name="descuento[]" id="de'+cont+'"><input type="hidden"class="form-control input-sm" value="normal" name="tipo[]" ></td><td>S/.<span id="imp'+cont+'">'+parseFloat(importe_ini[cont])+'</span></td></tr>';

                        cont++;
                         $('#contador_g').val(cont);
                         $("#total").html("S/. " +parseFloat(total).toFixed(2));
                         $("#msm").html("S/. " +parseFloat(total).toFixed(2));
                         $('#monto').val(parseFloat(total).toFixed(2));
                         $('#detalles').append(fila);
                }); //fin data

            }

            
        }
    

    });

    $('#btn_d').click(function(){
        
        //precio detallado  => AJAX
        var plus_precio1= $('#btn_d').val();
        var plus_can0= $('#can').val();
        var plus_can=  parseFloat(plus_can0);
        var id_t0=$('#id_tra').val();
        var id_t=parseFloat(id_t0);
        var stock_ac0=$('#st_'+id_t).val();
        var stock_ac= parseFloat(stock_ac0);
        //DETALLE :c

        var stock_det0=$('#sd_'+id_t).val();
        var stock_det= parseFloat(stock_det0);
        //logitud total

        var long0=$('#lon_'+id_t).val();
        var long= parseFloat(long0);

        if(plus_can=='0' || plus_can==''){
                            swal(
                                  'Mensaje del Sistema',
                                  'Ingrese una cantidad valida',
                                  'error'
                                );
        $('#can').val('');
        }else{ 

            //verificar q lo q pide no sea mayor q el stock actual conjutamnete con el de detalle, sumammos el metraje total o gr 
            var suma=(long*stock_ac)+stock_det;

            if(suma<plus_can){ //es decir si sumo todo el metraje y me da 5m y yo estoy pidiendo 10m ->pz q mande error

                            swal(
                                  'Mensaje del Sistema',
                                  'La cantidad solicitada es mayor a la existente',
                                  'warning'
                                );

            }else{

                //AJAX
                $.get('/ventas/venta/create/'+id_t+'/detalles',function(data){
                        var nombre_ar=$('#nom_'+id_t).val();
                        var id_ar=data[0].idarticulo;
                        var precio_d=data[0].precio_detalle;
                        ////////
                        var importe=plus_can*precio_d;
                        total=total+ parseFloat(importe);
                        $("#tot").val(parseFloat(total).toFixed(2));
                        incre=$('#contador_g').val();
                        cont=parseFloat(incre);

                        importe_ini[cont]=importe.toFixed(2);
                        console.log('imported' +importe_ini[cont]+' '+ cont);
                        id_traa[cont]=$('#id_tra').val();
                        tipo_p[cont]='detalle';
                        var descu=0;
                        //AGREGAMOS LA FILA 

                         var fila='<tr style="color:#888;" class="selected" id="fila'+cont+'"><td class="btn-col" style="white-space: nowrap"><a onclick="eliminar('+cont+');" class="btn btn-danger btn-xs"><i class="ti-close"></i></a><a onclick="editar('+cont+');" class="btn btn-warning btn-xs"><i class="ti-reload"></i></a></td><td><input type="hidden" name="idarticulo[]" value="'+id_ar+'">'+nombre_ar+'</td><td class="form-col"><input type="number" class="form-control input-sm" value="'+plus_can+'" name="cantidad_dt[]" id="ctd'+cont+'"></td><td class="form-col"><input type="number" class="form-control input-sm" value="'+precio_d+'" name="precio_unit[]" id="pv'+cont+'"><td class="form-col"><input type="number" class="form-control input-sm" value="0" name="descuento[]" id="de'+cont+'"><input type="hidden"class="form-control input-sm" value="detalle" name="tipo[]" ></td><td>S/.<span id="imp'+cont+'">'+parseFloat(importe_ini[cont])+'</span></td></tr>';

                           cont=cont+1;
                         $('#contador_g').val(cont);
                         $("#total").html("S/. " +parseFloat(total).toFixed(2));
                         $("#msm").html("S/. " +parseFloat(total).toFixed(2));
                         $('#monto').val(parseFloat(total).toFixed(2));
                         $('#detalles').append(fila);
                }); //fin data

            }

            
        }
       
    
    });
</script>

<script type="text/javascript">
    function eliminar(index){

                  
                    total=parseFloat(total)-parseFloat(importe_ini[index]);
                    $("#tot").val(parseFloat(total).toFixed(2));
                    $("#total").html("S/. " +total.toFixed(2));
                    $("#msm").html("S/. " +parseFloat(total).toFixed(2));
                     $('#monto').val(parseFloat(total).toFixed(2));
                    importe_ini[index]=0;
                    zr=0;
                    $("#de" + index).val(zr);
                    $("#fila" + index).remove();

 }

  function editar(index){

                  //primero multiplicamos la cantidad 
                  //extraemos su valor actual 
                   var cat_act= $("#ctd" + index).val();
                   var cat_act1=parseFloat(cat_act);
                   var des_act= $("#de" + index).val();
                   var des_act1=parseFloat(des_act);
                   var idtractual=id_traa[index];
                   //por AJAX

                     $.get('/ventas/venta/create/'+idtractual+'/detalles',function(data1){
                        //en este caso la consulta es diferente ya que.... lo haremos por el idarticulo 
        
                        var ca4=data1[0].cantidad_volumen1;
                        var ca5=data1[0].cantidad_volumen2;
                        var ca6=data1[0].cantidad_volumen3;
                        //viendo precios .. pero antes hay q ver si es detalle, pq eso no se descuenta por ser precio vol. 
                        
                        if(tipo_p[index]=='normal'){

                                    if(cat_act1<ca4){
                                    console.log('nada');
                                    var precio_u=data1[0].precio_venta;

                                    }else if(cat_act1>=ca4 && cat_act1<ca5){
                                        console.log('d1');
                                        var precio_u=data1[0].precio_mayor1;

                                    }else if(cat_act1>=ca5 && cat_act1<ca6){
                                        console.log('d2');
                                         var precio_u=data1[0].precio_mayor2;

                                    }else{
                                        console.log('d3');
                                        var precio_u=data1[0].precio_mayor3;
                                    }

                            ///

                        }else{

                            //ahora aqui el precio _u es de detalle ahora :'v '
                                var precio_u=data1[0].precio_detalle;
                        }
                        //actualizamso precio e importe 

                        $("#pv" + index).val(precio_u);

                        res=(cat_act1*precio_u)-(des_act1*cat_act1*precio_u/100);
                        res1=parseFloat(res).toFixed(2);
                        $("#imp" + index).html(res1);
                         importe_ini[index]=res1;
                         zer=0;
                         // para total recoremos todo el array de importe y sumamnos :v y si fue eliminado ya pz se supone q es cero
                         for (i=0;i<importe_ini.length;i++){
                            zer=parseFloat(zer)+ parseFloat(importe_ini[i]);
                            console.log(zer);
                          }
                          total=zer;


                        $("#tot").val(parseFloat(total).toFixed(2));
                        $("#total").html("S/. " +parseFloat(total).toFixed(2));
                        $("#msm").html("S/. " +parseFloat(total).toFixed(2));
                         $('#monto').val(parseFloat(total).toFixed(2));

                     });
 }

</script>
<script type="text/javascript">
      $('#cambiando').click(function(){
            //actaulizamos el input cambio
            var entre=$('#monto').val();
            var gene= $("#tot").val();
            var des_global_g=$('#des_global').val();
            var gene2=(parseFloat(gene)-(parseFloat(gene)*parseFloat(des_global_g)/100)).toFixed(2);
            var resta=parseFloat(entre)-parseFloat(gene2);
            
            $('#msm').html("S/. "+gene2);
            $('#adios').val(gene2);
            if(resta<0){
                //lo q entregue es menor al que sale; desplegamos credito

                    $("#tx_cambio0").html("A deuda");
                    $("#tx_cambio").html("S/. " +parseFloat(resta*(-1)).toFixed(2));
                    $('#cambio').val(0);
                    $('#deuda').val(parseFloat(resta*(-1)).toFixed(2));
                    $('#credi').css("display", "block");
                    $('#table_let').css("display", "block");
            

            }else{
                   $("#tx_cambio0").html("Cambio");
                   $("#tx_cambio").html("S/. " +parseFloat(resta).toFixed(2));
                   $('#cambio').val(parseFloat(resta).toFixed(2));
                   $('#deuda').val(0);
                   $('#credi').css("display", "none");
                   $('#table_let').css("display", "none");
                
            }

      });
</script>

<script type="text/javascript">
    var cont2=0;  
    $('#let').click(function(){
         var fecha_val=$('#fecha_px').val();
         if(fecha_val==''){

           swal(
                    'Mensaje del Sistema',
                    'Ingrese una Fecha Válida',
                    'warning'
               );

         }else{
           //agregamos la fecha :v


               var fila2='<tr style="color:#888;" class="selected" id="fila2'+cont2+'"><td><span id="fec'+cont2+'">'+parseFloat(cont2)+'</span></td><td class="form-col"><input type="date" class="form-control input-sm" value="'+fecha_val+'" name="fecha_cre[]"><td class="btn-col" style="white-space: nowrap"><a onclick="eliminar2('+cont2+');" class="btn btn-danger btn-sm"><i class="ti-close"></i></a></td></tr>';


                         cont2=cont2+1;
                         $('#let_fe').append(fila2);


         }
    });


     function eliminar2(index2){

                    $("#fila2" + index2).remove();

     }

</script>
<script type="text/javascript">
   

     $('#generado').change(function() {
        if($(this).is(":checked")) {
            $('#shin1').css("display", "block");
            $('#shin2').css("display", "block");
            $("#serie").prop('required',true);
            $("#corre").prop('required',true);
        }else{
            $('#shin1').css("display", "none");
            $('#shin2').css("display", "none");
            $("#serie").prop('required',false);
            $("#corre").prop('required',false);
        }
              
    });
</script>

 @endpush
@endsection
