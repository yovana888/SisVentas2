
<div class="modal fade" id="modal-show-{{$ped->idnotificacion_pedido}}" role="dialog">
<div class="modal-dialog" style="width:60% !important; ">
      <div class="modal-content" style="border-radius: 0px 0px 0px 0px;">
        <div class="modal-header" style="background:#444; height:70px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="ti-close" style="color:#fff"></i></span>
          </button>        
           <h3 class="modal-title " style="color:#fff; "><i class="ti-bookmark"></i>Detalles del Pedido</h3>      
        </div>
        <div class="modal-body" style="background:#fff;  ">
      
  {!!Form::model($ped,['method'=>'PATCH','route'=>['pedidos.entrantes.update',$ped->idnotificacion_pedido]])!!}
  <input type="text" name="emisor" value="{{$ped->idemisor}}" hidden="hidden">
         <div class="table-responsive">
          <table class="table m-1"  >
            <thead > <!--mandando variable-->
              <tr style="color: #888;">      
                <th style="display:none;">id</th>
                <th>Articulo</th>
                <th>Cant.</th>
                <th>Mi stock</th>
                <th>Cant. prov.</th>

              </tr>
            </thead>
            <tbody>
              @foreach ($details as $del)
                       @if($del->idnotificacion_pedido==$ped->idnotificacion_pedido)
                        <tr  style="color: #888;" >  
                            <td style="display:none;">
                            <input type="number" name="" value="{{$del->iddetalle_pedido}}" class="form-control" id="edit0_{{$del->iddetalle_pedido}}" style="width:60px; text-align:center;"></td>

                            <td>{{ $del->articulo}}/{{$del->tam_nro1}} {{$del->UN1}} - {{$del->tam_nro2}} {{$del->UN2}}</td>
                            <td class="form-col"><input type="number" name="" value="{{ $del->cantidad}}" class=" input-sm form-control" disabled id="edit1_{{$del->iddetalle_pedido}}" style="width:60px; text-align:center;"></td>

                            <td>{{ $del->num_stock_gn}}</td>
                            <td class="form-col"> <input type="number" name="" value="{{$del->cant_pp}}" class="form-control input-sm"  disabled id="edit2_{{$del->iddetalle_pedido}}" style="width:60px; text-align:center;"></td>
                            
                            <td>
                                <button type="button" class="btn btn btn-xs" style="background: rgba(170, 102, 200, 0.9); color: #fff; margin-left:10px;" value="{{$del->iddetalle_pedido}}" id="btn_edit_{{$del->iddetalle_pedido}}" onclick="fnProcesa(this)"><i class="ti-pencil"></i></button>
                               
                               <button type="button" class="btn btn btn-xs" style="background:rgba(0, 200, 83, 0.9); color: #fff; margin-left:10px;" value="{{$del->iddetalle_pedido}}" id="btn_save_{{$del->iddetalle_pedido}}" onclick="fnProcesa2(this)" disabled="disabled"><i class="ti-save"></i></button>
                               
                               <button type="button" class="btn btn btn-xs" style="background: #607d8b; color: #fff; margin-left:10px;" value="{{$del->iddetalle_pedido}}" id="btn_cancel_{{$del->iddetalle_pedido}}" onclick="fnProcesa3(this)"><i class="ti-close"></i></button>
                            </td>
                        </tr>

                        @endif
                @endforeach
              
            </tbody>
          </table>
         </div>
       
          <br>
          <br>
          <div class="row" style="margin-left: 5px;">
            <span class="label label" style="background: #bbb; color: #fff; margin-left:6px;">Nota</span> 
            <div class="col-md-12 input-group input-group-lg">
              <input type="text" name="nota" class="form-control"  style="font-size: 12px; height: 27px; color: #888;">
            </div>
          </div> 

      
    </div>

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          @if($ped->estado=='En espera')
          <button type="submit" class="btn btn" style="background:#ff5252;color:#fff;">Trasladar</button>
          @else
          <button type="submit" class="btn btn" style="background:#ff5252;color:#fff;" disabled="disabled">Trasladar</button>
          @endif
        </div>
        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
      {!!Form::close()!!}
  </div><!-- /.modal -->
  
 
@push ('scripts')
<script src="{{asset('assets\plugins\jquery\jquery-1.9.1.min.js')}}"></script>
<script type="text/javascript">
function fnProcesa(comp){
  let id = comp.id; //el id completo del button :v , para editar 
  console.log(id);
 var cad_id= id.substr(9);
 $("#edit2_"+cad_id).prop( "disabled",false);
 $("#edit1_"+cad_id).prop( "disabled",false);
 $("#btn_save_"+cad_id).prop( "disabled",false);
}

function fnProcesa2(comp2){
   let id = comp2.id; //el id completo del button :v , para guardar
   var cad_id2= id.substr(9);
   var cant= $("#edit1_"+cad_id2).val(); 
   var cant_p=$("#edit2_"+cad_id2).val();
 $.get('/pedidos/entrantes/show/'+cad_id2+'/editar/'+cant+'/values/'+cant_p,function(){
    //una vez q lo guarde procedemos a hacer display al mensaje y bloquear los inputs
  
  $("#edit2_"+cad_id2).prop("disabled",true);
  $("#edit1_"+cad_id2).prop( "disabled",true);
  $("#btn_save_"+cad_id).prop( "disabled",true);
            swal(
                  'Mensaje del Sistema',
                  'El detalle se editó correctamente',
                  'success'
                )
  });
}


function fnProcesa3(comp3){
  let id = comp3.id; //el id completo del button :v , para guardar
  var cad_id3= id.substr(11);
  $("#edit2_"+cad_id3).prop( "disabled",true);
  $("#edit1_"+cad_id3).prop( "disabled",true);
  $("#btn_save_"+cad_id).prop( "disabled",true);
}



</script>


@endpush
