
<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-show-{{$ven->idventa}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 0px 0px 0px 0px;">
            <div class="modal-header" style="background:#444; height:70px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ti-close" style="color:#fff"></i></span>
                </button>
             <h3 class="modal-title " style="color:#fff; "><i class="ti-menu"></i> Detalles del Ticket-Boleta: {{$ven->serie_comprobante}} - {{$ven->num_comprobante}}</h3>
            </div>
        <div class="modal-body" style="background:#f8f8f8;">
        <table class="table">
        <thead>
          <tr>
                        <th style="display:none;">id</th>
                        <th>Articulo</th>
                        <th>Cantidad</th>
                        <th>P.Unitario</th>
                        <th>Dscto</th>
                        <th>Importe</th>

          </tr>
        </thead>
        <tbody>
        @foreach($detalles as $dt)
          @if($dt->idventa==$ven->idventa)
          <tr>
            <th style="display:none;">{{$dt->iddetalle_venta}}</th>
            <td>{{$dt->articulo}} / {{$dt->tam_nro1}} {{$dt->UN1}} - {{$dt->tam_nro2}} {{$dt->UN2}}</td>

            @if($dt->unidad=='normal')
            <th>{{$dt->cantidad}} {{$dt->medida_stock_gn}} (s)</th>
            @else
            <th>{{$dt->cantidad}} {{$dt->medida_stock_det}}</th>
            @endif
            
            <td>{{$dt->precio_venta}}</td>
            <td>{{$dt->descuento}}</td>
            <td>{{$dt->subtotal}}</td>
          </tr>
          @endif
        @endforeach
        </tbody>
      </table>
            <span class="label label-pink">NOTA</span>
            <p style="color:#888;">{{$ven->nota}}</p>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>

        </div>
    </div>

</div>

