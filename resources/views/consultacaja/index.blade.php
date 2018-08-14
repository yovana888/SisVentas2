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
  <li class="active"><a href="#" id="m1" style="color:#e91e63;">CAJA ALL</a></li>

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
                <th style="white-space: nowrap; color:#888;">fecha</th>
                <th style="white-space: nowrap; color:#888;">Hora Apertura</th>
                <th style="white-space: nowrap; color:#888;">Hora Cierre</th>
                <th style="white-space: nowrap; color:#888;" >Monto Apertura</th>
                <th style="white-space: nowrap; color:#888;" >Monto Cierre</th>
                <th style="white-space: nowrap; color:#888;" >Estado</th>
                 <th style="white-space: nowrap; color:#888;" >Opciones</th>
              </tr>
            </thead>
            <tbody>

                 @foreach ($caja as $ca)
                <tr style="color:#888;">
                  <td>{{$ca->idcaja}}</td>
                  <td>{{$ca->fecha}}</td>
                  <td>{{$ca->hora_apertura}}</td>
                  <td>{{$ca->hora_cierre}}</td>
                  <td>{{$ca->monto_aper}}</td>
                  <td>{{$ca->monto_cierre}}</td>
                  @if($ca->estado=='abierto')
                  <td ><span class="label label-success">{{$ca->estado}}</span></td>
                   <td>
                    <a href="" data-target="#modal-delete-{{$ca->idcaja}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><i class="ti-close"></i></button></a>

                        <a  href="{{URL::action('ConsultaCajaController@show',$ca->idcaja)}}" ><button class="btn btn btn-xs" style="background:#00bcd4; color:#fff;font-weight: bold;"><i class="ti-menu"></i></button></a>
                   </td>
                    
                  @else
                    <td ><span class="label label-info">{{$ca->estado}}</span></td>
                    <td>
                       <a href="" data-target="#modal-delete-{{$ca->idcaja}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"  disabled="disabled"><i class="ti-close"></i></button></a>
                      <a  href="{{URL::action('ConsultaCajaController@show',$ca->idcaja)}}" ><button class="btn btn btn-xs" style="background:#00bcd4; color:#fff;font-weight: bold;"><i class="ti-menu"></i></button></a>
                    </td>
                       
                  @endif
                 
                </tr>
                 @include('consultacaja.modal',[$ca])
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
