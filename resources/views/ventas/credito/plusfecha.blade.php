
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-fecha-{{$cr->idcredito}}">
{!!Form::open(array('url'=>'ventas/credito/fechas','method'=>'POST','autocomplete'=>'off'))!!}
  <div class="modal-dialog ">
    <div class="modal-content" style="border-radius: 0px 0px 0px 0px;">
      <div class="modal-header" style="background:#444; height:70px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="ti-close" style="color:#fff"></i></span>
        </button>
           <h3 class="modal-title " style="color:#fff; "><i class="ti-menu"></i> Fechas del Crédito {{$cr->serie_comprobante}} - {{$cr->num_comprobante}}</h3>
      </div>
      <div class="modal-body" style="background:#f8f8f8;">
    <div class="row">
      <div class="col-md-9">
        <div class="table-responsive">
          
             <table class="table">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Fechas de Pago</th>
                        <th>Opc</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($pfechas as $pf)
                      @if($pf->idcredito==$cr->idcredito)
                      <tr>
                        <tr>
                             <td >{{$pf->iddetalle}}</td>
                             <td ><?PHP  echo date('d-m-Y',strtotime($pf->fecha)); ?></td>
                             
                             <td><button class="btn btn-danger btn-xs"><i class="ti-close"></i></button></td>
                        </tr>

                      </tr>
                      @endif
                    @endforeach
                    </tbody>
                  </table>
         
          </div>
        </div>

          <div class="col-md-2" style="margin-left: 20px; border-left: 1px solid #888;" id="fechas">
                <p style="color: #888;">Proxima Fecha</p>
                <div class="row" >
                   @if($cr->estado=='Pagado')
                          <code>{{$cr->fecha_px}}</code>
                  @else
                  <code><?PHP  echo date('d-m-Y',strtotime($cr->fecha_px)); ?></code>
                  @endif
                </div>
        </div>
      </div>
      <div class="row">


        <h5 class=""><span class="label label" style="color:#fff; font-size:12px; background:#5cb85c; margin-left:2%;">Nueva Fecha</span></h5>

               <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                  <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1">Fecha Prox.</span>
                      <input type="date" class="form-control" aria-describedby="basic-addon1" name="fecha_px" >
                    </div>
               </div>

             
               <input type="text" name="idcre2" value="{{$cr->idcredito}}"  id="idcre" hidden="hidden">
            
      </div>
      </div>
       {!!Form::close()!!}
      <div class="modal-footer">

        <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        @if($cr->resto=='0')
        <button type="submit" class="btn btn-pink" disabled>Guardar</button>
        @else
          <button type="submit" class="btn btn-pink" >Guardar</button>
        @endif

      </div>

    </div>
  </div>



</div>
@push ('scripts')

<script type="text/javascript">



</script>


       
@endpush
