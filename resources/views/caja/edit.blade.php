
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-cerrar">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="border-radius: 0px 0px 0px 0px;">
			<div class="modal-header" style="background:#444; height:70px;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										 <span aria-hidden="true"><i class="ti-close" style="color:#fff"></i></span>
				</button>
          <h3 class="modal-title " style="color:#fff; "><i class="ti-bookmark"></i>Cerrar Caja</h3>
			</div>
			<div class="modal-body" style="background:#f8f8f8; ">
                 
     {!!Form::model($caja,['method'=>'PATCH','route'=>['caja.update',$id]])!!}
      {{Form::token()}}

      <div class="row">
      	<input type="text" name="estado" value="{{$estado}}" hidden="hidden">
        <div class="col-md-12">
            <span style="color:#888; font-size: 15px;">Fecha <?PHP  echo date('d-m-Y',strtotime($fecha)); ?></span><br><br>
              <span style="color:#888; font-size: 15px;">Apertura: S/. {{$apert}}</span><br><br>
              <span style="color:#888; font-size: 15px;">Cierre:  S/. {{$mostrar}}</span><br><br>
              <input type="checkbox" name="rea" value="1"><label class="text-pink">Reaperturar</label>
            
        </div>
      </div>

      <div class="row">
        
      </div> 

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Guardar</button>
			</div>
    {!!Form::close()!!}
		</div>
	</div>

</div>

<style>

</style>
