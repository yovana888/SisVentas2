@extends ('layouts.admin')
@section ('contenido')

<style type="text/css">
  .btn-circle.btn-lg {
  width: 50px;
  height: 50px;
  padding: 10px 16px;
  font-size: 18px;
  line-height: 1.33;
  border-radius: 25px;
}
</style>

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
  @include('caja.create',[$fecha,$ultim]) 
    @if($estado=='abierto' || $estado=='cerrado')
   <a href=""  data-target="#modal-create" data-toggle="modal"><button type="button" disabled="disabled" class="btn btn-info btn-circle "><i class="ti-export"></i></button></a>
   @else
   <a href=""  data-target="#modal-create" data-toggle="modal"><button type="button" id="com" class="btn btn-info btn-circle "><i class="ti-export"></i></button></a>
   @endif

  @include('caja.plus',[$id])
   @if($estado=='cerrado' || $estado=='')
       <a href=""  data-target="#modal-transaccion" data-toggle="modal"><button disabled="disabled" type="button" class="btn btn-success btn-circle "><i class="ti-plus"></i></button></a>
   @else
       <a href=""  data-target="#modal-transaccion" data-toggle="modal"><button type="button" class="btn btn-success btn-circle "><i class="ti-plus"></i></button></a>
   @endif
 

   @include('caja.edit',[$id,$apert,$mostrar,$caja,$estado])


  @if( $estado=='')
  <a href=""  data-target="#modal-cerrar" data-toggle="modal"><button type="button" disabled="disabled"  class="btn btn-default btn-circle "><i class="ti-import"></i></button></a>
  @else
    <a href=""  data-target="#modal-cerrar" data-toggle="modal"><button type="button" class="btn btn-default btn-circle "><i class="ti-import"></i></button></a>
  @endif

  <label class="text-pink" style="font-weight: bold; font-size:12px;">[{{$estado}}]</label>
    <span class="label label-pink" style="font-size: 15px; margin-left: 80%;">S/. {{$mostrar}}</span>
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
                <th style="white-space: nowrap; color:#888;" >Editar</th>
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
                  <td><button type="button" class="btn btn-warning btn-xs"><i class="ti-pencil"></i></button></td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div> 

         @foreach($ultim as $ul)
           
            <input type="text" name="apu" id="apu" value="{{$ul->estado}}"  hidden="hidden">
       
      @endforeach

      </div>

        <div class="panel-footer clearfix">
        
       
        </div>
    


</div>
        @push ('scripts')
          <script src="{{asset('assets\plugins\jquery\jquery-1.9.1.min.js')}}"></script>
          <script type="text/javascript">

              $('#com').click(function(){
                var apura=$('#apu').val();

                if (apura=='abierto'){

                     $('#ape').prop( "disabled", true);

                        swal(
                                  'Mensaje del Sistema',
                                  'Por favor, cierre la caja de ayer, para continuar',
                                  'warning'
                                );

                }else{
                     $('#ape').prop( "disabled", false);
                }

              });
                           
          </script>
         @endpush
@endsection
