
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-create">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="border-radius: 0px 0px 0px 0px;">
			<div class="modal-header" style="background:#444; height:70px;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										 <span aria-hidden="true"><i class="ti-close" style="color:#fff"></i></span>
				</button>
          <h3 class="modal-title " style="color:#fff; "><i class="ti-bookmark"></i>Aperturar Caja</h3>
			</div>
			<div class="modal-body" style="background:#f8f8f8; ">
                 
      {!!Form::open(array('url'=>'caja','method'=>'POST','autocomplete'=>'off'))!!}
      {{Form::token()}}

      <div class="row">
        <div class="col-md-12">
            <span style="color:#888; font-size: 15px;">Fecha <?PHP  echo date('d-m-Y',strtotime($fecha)); ?></span><br><br>
            <span style="color:#888; font-size: 15px;">Monto: <input style="color: #888; margin-top: 10px;" type="number" min="1" name="monto_a" id="monto_a" class="form-control"></span><br>
            @foreach($ultim as $ul)
            <input type="text" name="mon_ayer" id="mon_ayer" value="{{$ul->monto_cierre}}" hidden="hidden">
            <input type="text" name="id_ayer" id="id_ayer" value="{{$ul->idcaja}}"  hidden="hidden">
            <input type="text" name="es_ayer" id="es_ayer" value="{{$ul->estado}}"  hidden="hidden">
            <input type="checkbox" name="ayer" id="ayer" value="1"><span class="text-pink">Aperturar en base a lo de ayer</span>
			@endforeach

        </div>
      </div>

      <div class="row">
        
      </div> 

			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-success" id="ape">Aperturar</button>
			</div>
    {!!Form::close()!!}
		</div>
	</div>

</div>
@push ('scripts')
          <script src="{{asset('assets\plugins\jquery\jquery-1.9.1.min.js')}}"></script>

          <script type="text/javascript">
			  $('#ayer').change(function() {
		        if($(this).is(":checked")) {
		        	console.log('entre');
		           var mon=$('#mon_ayer').val();
		           $('#monto_a').val(mon);
		        }else{
		            $('#monto_a').val(0);
		        }
		              
		    });

		</script>
@endpush

