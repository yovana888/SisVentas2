
<div class="modal fade" id="modal-resumen" role="dialog">
<div class="modal-dialog" style="width:60% !important; ">
      <div class="modal-content" style="border-radius: 0px 0px 0px 0px;">
        <div class="modal-header" style="background:#444; height:70px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="ti-close" style="color:#fff"></i></span>
          </button>        
           <h3 class="modal-title " style="color:#fff; "><i class="ti-bookmark"></i>Detalles del Pedido</h3>      
        </div>
        <div class="modal-body" style="background:#fff;  ">
     

  
  <input type="text" name="emisor" value="{{$ped->idemisor}}" hidden="hidden">


        <div class="row">
          <div class="col-md-7 col-xs-12">
          <div class="table-responsive"  style="height: 30%;">
          <table class="table m-1" >
            <thead > <!--mandando variable-->
              <tr style="color: #888;">         
               
                <th>Nombre</th>
                 <th>Telefono</th>
                  <th>Correo</th>
                <th>Opc</th>
              </tr>
            </thead>
            <tbody>
              @foreach($proveedores2 as $pv)
                    
                        <tr  style="color: #888;" >   
  
                          <td>{{ $pv->nombre}}</td>
                          
                          <td>{{ $pv->telefono}}</td>

                          <td>{{ $pv->email}}</td>
                        
                           <td>

                    

                               <button type="button" class="btn btn btn-xs" style="background:rgba(0, 200, 83, 0.9); color: #fff; margin-left:10px;" value="{{$pv->idpersona}}" id="visual_{{$pv->idpersona}}" onclick="visual(this)"><i class="ti-plus"></i></button>
                              
                              
                            </td> 


                        </tr>

                     
                @endforeach
              
            </tbody>
          </table>
         </div>
          </div>
          <div class="col-md-5 col-xs-12" style="padding: 5px;">
            <span class="label label-info">Articulos</span>
            <div class="well" style="height: 30%" id="inori">
              
            </div>
          </div>
        </div>
        
        
        
      
    </div>

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  
        </div>
        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    
  </div><!-- /.modal -->
  
 
@push ('scripts')

<script type="text/javascript">

function visual(vi){
   let id = vi.id; //el id completo del button :v , para guardar
   var param= id.substr(7);
     $('#inori').empty();
  $.get('/pedidos/proveedor/show2/'+param,function(data){
    
        var html_se='<br>';
        for(var i=0;i<data.length;i++){
              html_se +='<label style="color:#888;">'+data[i].articulo_com+' <span class="label label-pink" style="font-size:11px;">'+data[i].total+'</span></label><br>';

              }
          

          $('#inori').html(html_se);
  });
}



</script>


@endpush
