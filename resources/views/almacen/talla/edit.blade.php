
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-edit-{{$tall->idtalla}}">
	<div class="modal-dialog">
		<div class="modal-content" style="border-radius: 15px 15px 15px 15px;">
			<div class="modal-header" style="background:#333; border-radius: 10px 10px 0px 0px;">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true"><i class="fa fa-close" style="color:#fff"></i></span>
                </button>
                 <h5 class="modal-title" style="color:#fff;"><span class="label label" style="color:#fff; background:#019299; font-size:12px;">Editar Talla:</span><span style="color:#d9d6d8;"> {{ $tall->nombre}}</span></h5>
			</div>
			<div class="modal-body" style="background:#f8f8f8; border-radius: 0px 0px 10px 10px; ">
                     <!--Eso es pq me retorna categoria-->
                     
                     @if (count($errors)>0)
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                                </ul>
                            </div>
                         </div>
                     @endif
                     
                     	{!!Form::model($tall,['method'=>'PATCH','route'=>['almacen.talla.update',$tall->idtalla]])!!}
                        {{Form::token()}}
                    <div class="form-group">
                        <label for="nombre" style="color:#019299;">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{$tall->nombre}}" placeholder="Nombre..." style="color:#777;">
                    </div>
                    

                    <div class="form-group">
                        <label style="color:#019299;">Subcategoría</label>
                        <select name="idsubcategoria" class="form-control">
                            @foreach ($subcategorias as $sb)
                                @if ($sb->idsubcategoria==$tall->idsubcategoria)
                               <option value="{{$sb->idsubcategoria}}" selected>{{$sb->nombre}}</option>
                               @else
                               <option value="{{$sb->idsubcategoria}}">{{$sb->nombre}}</option>
                               @endif
                            @endforeach
                        </select>
                    </div>
                    
                     <div class="form-group">
                      <label for="descripcion" style="color:#019299;">Estado</label>
            	     <select name="estado" class="form-control">
                        @if ($tall->estado=='Activo')
                            <option value="Activo" selected>Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        @else
                           <option value="Inactivo" selected>Inactivo</option>
                            <option value="Activo">Activo</option>
                        @endif
                    </select>
                    </div>
		        
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" style=" background:#019299;" >Guardar</button>
			</div>
    {!!Form::close()!!}	
		</div>
	</div>

  <!---<button class="btn btn-success" type="button" onclick="generarBarcode()">Generar</button>--->
                
</div>

<style>

</style>


