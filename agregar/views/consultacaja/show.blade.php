@extends ('layouts.admin')
@section ('contenido')



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
  <li class="active"><a href="#" id="m1" style="color:#e91e63;">DETALLES DE LA CAJA </a></li>

</ul>
  <div class="panel panel-default " style="margin-left: 3%; margin-right :3%;" id="rem1">


        <br>
        <br>
        <div class="panel-body">
            
          <div class="table-responsive">
           <table id="datatables-default" class="table  m-0 ">
            <thead>
              <tr >
                    <th style="white-space: nowrap; width:2%; color:#888;">id</th>
                    <th style="white-space: nowrap; color:#888;">descripción</th>
                    <th style="white-space: nowrap; color:#888;">Hora</th>
                    <th style="white-space: nowrap; color:#888;">Tipo</th>
                    <th style="white-space: nowrap; color:#888;" >monto</th>
              </tr>
            </thead>
            <tbody>

                 @foreach ($detalles as $det)
                <tr style="color:#888;">
                  <td>{{$det->iddetalle_caja}}</td>
                  <td>{{$det->descripcion}}</td>
                  <td>{{$det->hora}}</td>
                  <td>{{$det->tipo}}</td>
                  @if($det->tipo=='Entrada')
                  <td style="color:#3f51b5; font-weight: bold;">S/. {{$det->monto}}</td>
                  @else
                   <td class="text-pink" style="font-weight: bold;">S/. {{$det->monto}}</td>
                  @endif
                 
                </tr>
                @endforeach
            </tbody>
          </table>
        </div> 

      </div>

        <div class="panel-footer clearfix">
        
       
        </div>
    


</div>
        @push ('scripts')
          <script src="{{asset('assets\plugins\jquery\jquery-1.9.1.min.js')}}"></script>
         
         @endpush
@endsection
