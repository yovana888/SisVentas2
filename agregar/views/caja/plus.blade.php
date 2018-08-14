
<style type="text/css">
	input[type="radio"] {
  display: none;
}

input[type="radio"] + label {
  color: #292321;
  font-family: Arial, sans-serif;
  font-size: 12px;
}

input[type="radio"] + label span {
  display: inline-block;
  width: 19px;
  height: 19px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  -moz-border-radius: 50%;
  border-radius: 50%;
}

input[type="radio"] + label span {
  background-color: #292321;
}

input[type="radio"]:checked + label span {
  background-color: #c7254e;
}

input[type="radio"] + label span,
input[type="radio"]:checked + label span {
  -webkit-transition: background-color 0.4s linear;
  -o-transition: background-color 0.4s linear;
  -moz-transition: background-color 0.4s linear;
  transition: background-color 0.4s linear;
}
</style>
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-transaccion">
	<div class="modal-dialog">
		<div class="modal-content" style="border-radius: 0px 0px 0px 0px;">
			<div class="modal-header" style="background:#444; height:70px;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										 <span aria-hidden="true"><i class="ti-close" style="color:#fff"></i></span>
				</button>
          <h3 class="modal-title " style="color:#fff; "><i class="ti-bookmark"></i>Nuevo movimiento de Caja</h3>
			</div>
			<div class="modal-body" style="background:#f8f8f8; ">
                 
      {!!Form::open(array('url'=>'caja/detalle','method'=>'POST','autocomplete'=>'off'))!!}
      {{Form::token()}}

      <div class="row">
      	<input type="text" name="id_cj" value="{{$id}}" hidden="hidden">
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <input type="radio" id="radio01" name="radio" checked value="Entrada" />
                    <label for="radio01" style="color:#888;"><span></span> Entrada </label>

              </div>
          
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                     <input type="radio" id="radio02" name="radio" value="Salida" style="margin-left:10px;"/>
                     <label for="radio02" style="color:#888;"><span></span>Salida</label>
                </div>   
      </div>

      <div class="row">
      	<br>
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <input type="text" name="descripcion" class="form-control" style="color:#888;" placeholder="Descripción" />
                   
             </div> 
      </div> 

      <div class="row">
      	<br>
      		<div class="col-md-6">
      			<div class="input-group">
                                  <span class="input-group-addon" id="basic-addon1">S/. </span>
                                  <input type="number" style="color:#888;" class="form-control" name="dinero" id="dinero">
                                   <span class="input-group-btn">
                                       <button class=" btn btn-pink" id="let" type="submit" style="height: 34px;"><i class="ti-shift-right"></i></button>
                                 </span>
                 </div>
      		</div>
      		
      </div>

			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				
			</div>
    {!!Form::close()!!}
		</div>
	</div>

</div>

<style>

</style>
