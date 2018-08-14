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
  <li class="active"><a href="#" id="m1" style="color:#e91e63;">VENTAS/CLIENTES</a></li>

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
            <h4><span style="color:#9c27b0;">Clientes</span> Registrados</h4>
        </div>
<!-- END panel-heading -->
<!-- BEGIN panel-body -->
        <div class="panel-body">

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

          <div class="table-responsive">
          <table id="datatables-default" class="table  m-1">
				<thead>
					<tr style="text-align:center; " >
						<th style="white-space: nowrap; color:#888; display:none;"></th>
						<th style="white-space: nowrap; color:#888;" >Nombre</th>
						<th style="white-space: nowrap; color:#888;">DNI</th>
						<th style="white-space: nowrap; color:#888;">Direccion</th>
						<th style="white-space: nowrap; color:#888;">Telefono</th>
						<th style="white-space: nowrap; color:#888;">Email</th>
						<th style="white-space: nowrap; color:#888;">Ruc</th>
            <th style="white-space: nowrap; color:#888;">Cuenta</th>
            <th style="white-space: nowrap; color:#888;">Est</th>
            <th style="white-space: nowrap; color:#888;">Opciones</th>
					</tr>
				</thead>
				<tbody>
					  @foreach ($personas as $per)
            @if($per->nombre=='-Libre-')
            @else
                <tr style="color:#888;">
                  <td style="display:none;">{{ $per->idpersona}}</td>
                  <td>{{ $per->nombre}}</td>
                  <td>{{ $per->num_documento}}</td>
                  <td>{{ $per->direccion}}</td>
                  <td>{{ $per->telefono}}</td>
                  <td>{{ $per->email}}</td>
                  <td >{{ $per->cuenta}}</td>
                  <td>{{ $per->ruc}}</td>
                  @if ($per->estado=='Activo')
                  <td><i class="ti-check" style="color:#3fa143;font-weight: bold;"></i></td>
                  @else
                  <td><i class="ti-close" style="color:#2F4F4F;font-weight: bold;"></i></td>
                  @endif
                  <td>
                      <a href=""  data-target="#modal-edit-{{$per->idpersona}}" data-toggle="modal"><button class="btn btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="editar" style="background:#00bcd4; color:#fff;font-weight: bold;" ><i class="ti-pencil"></i></button></a>

                    <a href="" data-target="#modal-delete-{{$per->idpersona}}" data-toggle="modal"><button class="btn btn-danger btn-xs"><i class="ti-close"></i></button></a>
                  </td>
                  </tr>
                  @endif
						
            @include('ventas.cliente.edit',[$per])
            @include('ventas.cliente.modal')
						@endforeach
				</tbody>
			</table>

    </div>

        </div>

        <div class="panel-footer clearfix">

          @include('ventas.cliente.create')
            <a href=""  data-target="#modal-create" data-toggle="modal"><button class="btn btn-pink btn-sm pull-left m-l-5" >Nuevo Cliente</button></a>
              <a href=""  data-target="#" data-toggle="modal"><button class="btn btn btn-sm pull-left m-l-5" style="background:#999;color:#fff;">Reporte Avanzado</button></a>

        </div>
</div>
        @push ('scripts')
        	<script src="{{asset('assets\plugins\jquery\jquery-1.9.1.min.js')}}"></script>

         @endpush
@endsection
