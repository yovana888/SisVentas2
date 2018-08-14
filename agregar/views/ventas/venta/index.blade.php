@extends ('layouts.admin')
@section ('contenido')
<!-- BEGIN panel-heading -->
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
  <li class="active"><a href="#" id="m1" style="color:#e91e63;">VENTAS</a></li>

</ul>
  <div class="panel panel-default " style="margin-left: 3%; margin-right :3%;" id="rem1">

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
            <h4><span style="color:#9c27b0;">Ventas</span> Registradas</h4>
        </div>
<!-- END panel-heading -->
<!-- BEGIN panel-body -->
        <div class="panel-body">

          <div class="table-responsive">
          <table id="datatables-default" class="table  m-1">
				<thead>
					<tr  >
						<th  style="white-space: nowrap; color:#888;display: none;"></th>
						<th  style="white-space: nowrap; color:#888;">Fecha</th>
						<th  style="white-space: nowrap; color:#888;">Cliente</th>
						<th  style="white-space: nowrap; color:#888;">Comprobante</th>
            <th  style="white-space: nowrap; color:#888;">Dscto</th>
						<th  style="white-space: nowrap; color:#888;">Total</th>
						<th  style="white-space: nowrap; color:#888;">Estado</th>
						<th  style=" color:#888;">Opciones</th>
					</tr>
				</thead>
        	<tbody>
               @foreach($ventas as $ven)
                <tr style="color:#888;">
                  <td style="display: none;">{{ $ven->idventa}}</td>
                  <td>{{ $ven->fecha_hora}}</td>
                  <td>{{ $ven->nombre}}</td>
                  <td>{{ $ven->serie_comprobante}} - {{$ven->num_comprobante}}</td>
                  <td>{{ $ven->descuento}}</td>
                  <td>{{ $ven->total_venta}}</td>

                     @if ($ven->estado=='Aceptado')
                     <td><span class="label label-success">{{ $ven->estado}}</span></td>
                     @elseif($ven->estado=='Por Cobrar')
                     <td><span class="label label-warning">{{ $ven->estado}}</span></td>
                     @elseif($ven->estado=='Anulado')
                     <td><span class="label label-danger">{{ $ven->estado}}</span></td>
                     @else
                       <td><span class="label label-info">{{ $ven->estado}}</span></td>
                     @endif

                  <td >
                     @include('ventas.venta.show',[$ven->serie_comprobante,$ven->num_comprobante,$ven->nota])
                    <a href=""  data-target="#modal-show-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="Detalles"><i class="ti-menu"></i></button></a>

                    <a target="_blank" href="{{URL::action('VentaController@ticket',$ven->idventa)}}"><button class="btn btn btn-xs"  data-toggle="tooltip" data-placement="top" title="Reporte-Ticket" style="background:#d4a0dc; color: #fff;"><i class="ti-receipt"></i></button></a>

                    <a href="" data-target="#modal-delete-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="bottom" title="Cambiar estado" ><i class="ti-close"></i></button></a>
                  </td>
            </tr>
            @include('ventas.venta.modal')
            @endforeach
          </tbody>
			</table>

    </div>

        </div>

        <div class="panel-footer clearfix">

            <a href="venta/create"  ><button class="btn btn-pink btn-sm pull-left m-l-5" >Nueva Venta</button></a>
            <a href=""  data-target="#" data-toggle="modal"><button class="btn btn btn-sm pull-left m-l-5" style="background:#999;color:#fff;">Reporte Avanzado</button></a>
        </div>
</div>
        @push ('scripts')
        	<script src="{{asset('assets\plugins\jquery\jquery-1.9.1.min.js')}}"></script>

         @endpush
@endsection
