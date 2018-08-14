@extends ('layouts.admin')
@section ('contenido')
<style type="text/css">
    .zoom{
        /* Aumentamos la anchura y altura durante 2 segundos */
        transition: width 0.5s, height 0.5s, transform 0.5s;
        -moz-transition: width 0.5s, height 0.5s, -moz-transform 0.5s;
        -webkit-transition: width 0.5s, height 0.5s, -webkit-transform 0.5s;
        -o-transition: width 0.5s, height 0.5s,-o-transform 0.5s;
    }
    .zoom:hover{
        /* tranformamos el elemento al pasar el mouse por encima al doble de
           su tamaño con scale(2). */
        transform : scale(2);
        -moz-transform : scale(2);      /* Firefox */
        -webkit-transform : scale(2);   /* Chrome - Safari */
        -o-transform : scale(2);        /* Opera */
    }
</style>
<style media="screen">
@media (max-width: 1023px)
{
	.col-in li.col-middle {
	    width: 100%;
	}
}

.clickable{
    cursor: pointer;   
}

.panel-heading span {
	margin-top: -20px;
	font-size: 15px;
}

.col-in li.col-middle {
    width: 40%;
}
.white-box {
	background: #ffffff;
	padding: 25px;
	margin-bottom: 30px;
}
.box-title {
    margin: 0px 0px 12px;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 16px;
}
.col-in li.col-last {
    float: right;
}
.col-in {
    list-style: none;
    padding: 0px;
    margin: 0px;
}
@media (max-width: 1023px){
	.col-in {
	    padding: 15px 0;
	}
}
@media (max-width: 767px){
	.row-in-br {
	    border-right: 0px;
	    border-bottom: 1px solid rgba(120, 130, 140, 0.13);
	}
}
.col-in li {
    display: inline-block;
    vertical-align: middle;
    padding: 0 10px;
}
.row-in-br {
    border-right: 1px solid rgba(120, 130, 140, 0.13);
}
.col-in li .circle {
    display: inline-block;
}
.circle-md {
    width: 60px;
    padding-top: 10px;
    height: 60px;
    font-size: 24px!important;
}
.circle {
    border-radius: 100%;
    text-align: center;
    color: #ffffff;
}
.col-in h3 {
    font-size: 26px;
    font-weight: 100;
		color: #888;
}

.m-t-15 {
    margin-top: 20px !important;
}

.text-right {
    text-align: right;
}
.bg-danger {
    background-color: #ff7676 !important;
}
.bg-green{
	background-color: #53e69d !important;
}
.bg-morado{
	background-color: #7460ee !important;
}
.bg-azul{
	background-color: #11a0f8 !important;
}
</style>
<br>
<br>
<ul class="breadcrumb " style="margin-left: 3%; ">
	<li><a href="#" id="m1" style="color:#e91e63;">HOME</a></li>
	<li class="active" id="m2">GENERAL</li>
</ul>

<div class="row" style="padding-left:30px; padding-right:20px;">
	<div class="col-sm-12">
		<div class="white-box">
			<div class="row row-in">
				<div class="col-lg-3 col-sm-6 row-in-br">
					<ul class="col-in">
						<li>
							<span class="circle circle-md bg-danger" >
								<i class="ti-shopping-cart" ></i>
							</span>
						</li>
						<li class="col-last">

								  @foreach($comprashoy as $ch)
					 				@if($ch->totaldia=='')
					 				<h3  class="counter text-right m-t-15">S/. 0</h3>
					 				@else
					 				<h3  class="counter text-right m-t-15">S/. {{$ch->totaldia}}</h3>
					 				@endif
					 				@endforeach

							 <hr style=" border: 2px solid #ff7676;width:100px;">
						</li>
						<li class="col-middle">
              <h4 style="color:#888;">Total Hoy</h4>

						</li>
					</ul>
				</div>
				<div class="col-lg-3 col-sm-6 row-in-br">
					<ul class="col-in">
						<li>
							<span class="circle circle-md bg-green" >
								<i class="ti-money" ></i>
							</span>
						</li>
						<li class="col-last">

               <h3 class="counter text-right m-t-15">S/. 0.00</h3>
							 <hr style=" border: 2px solid #53e69d;width:100px;">
						</li>
						<li class="col-middle">
              <h4 style="color:#888;">Total Caja</h4>

						</li>
					</ul>
				</div>
				<div class="col-lg-3 col-sm-6 row-in-br">
					<ul class="col-in">
						<li>
							<span class="circle circle-md bg-morado" >
								<i class="ti-user" ></i>
							</span>
						</li>
						<li class="col-last">

							 <h3 class="counter   text-right m-t-15"><span style="color:#fff;">569g</span>{{$total1}}</h3>
							 <hr style=" border: 2px solid #7460ee; width:100px;">
						</li>
						<li class="col-middle">
							<h4 style="color:#888;">Proveedores</h4>

						</li>
					</ul>
				</div>
				<div class="col-lg-3 col-sm-6 row-in-br">
					<ul class="col-in">
						<li>
							<span class="circle circle-md bg-azul" >
								<i class="ti-truck" ></i>
							</span>
						</li>
						<li class="col-last">

							 <h3 class="counter  text-right m-t-15" ><span style="color:#fff;">569g</span>6</h3>
							 <hr style=" border: 2px solid #11a0f8; width:100px;">
						</li>
						<li class="col-middle">
							<h4 style="color:#888;">Traslados</h4>

						</li>
					</ul>
				</div>



			</div>
		</div>

	</div>
</div>
<style media="screen">
.border-head h3 {
	border-bottom: 1px solid #c9cdd7;
	margin-top: 0;
	margin-bottom: 20px;
	padding-bottom: 5px;
	font-weight: normal;
	font-size: 18px;
	display: inline-block;
	width: 100%;
	font-weight: 300;
}
</style>
<div class="row"  style="padding-left:30px; padding-right:20px;">
	<div class="col-md-7">
		<div class="border-head">
	      <h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;color:#888;">Gráfico de Compras-Días</font></font></h3>
	  </div>
		<canvas id="barraschart"  height="150"></canvas>
	</div>
	<div class="col-md-5" style="padding:10px;"> <!--NUevos articulos-->
         <div class="row">
         	<div class="col-md-12" >
         			<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title" style="color: #888;">Nuevos articulos Añadidos</h3>
							<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
						</div>
						<div class="panel-body">
							 <div class="table-responsive">          
								  <table class="table">
								    <tbody>
								    @foreach($articulos as $art)
								      <tr style="color: #777;">
								        <td><img class="img-thumbnail" src="{{asset('imagenes/variaciones/'.$art->imagen)}}" style="height: 60px; width: 60px;"></td>
								        <td style="color:#11a0f8;">{{$art->articulo}} / {{$art->tam_nro1}} {{$art->UN1}} - {{$art->tam_nro2}} {{$art->UN2}}</td>
								        <td><span class="label label-success" style="font-size: 12px;">{{$art->precio_normal_u}}</span></td>
								      </tr>
								      @endforeach
								    </tbody>
								  </table>
								 </div>
						</div>
					</div>
         	</div>
         </div>
	</div>
</div>


<div class="row"  style="padding-left:30px; padding-right:20px;">
	<div class="col-md-5">
			<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title" style="color: #777;">Articulos más Comprados</h3>
							<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
						</div>
						<div class="panel-body">
							 <div class="table-responsive">          
										  <table class="table">
										    <tbody>
										    @foreach($mascomprado as $cm)
										      <tr style="color: #777;">
										        <td style="color:#999;">{{$cm->articulo}} color {{$cm->color}}/ {{$cm->tam_nro1}} {{$cm->UN1}} - {{$cm->tam_nro2}} {{$cm->UN2}}</td>
										        <td><span class="label label-purple" style="font-size: 12px;">{{$cm->cantidad}}</span></td>
										      </tr>
										      @endforeach
										    </tbody>
										  </table>
							  </div>
						</div>
				     </div>
			</div>
			<div class="row">
				 <div class="col-md-12">
				 	<div class="row">
				

					      <div class="alert alert-danger m-b-10">
								<strong><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">¡Aviso! </font></font></strong><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Compras Anuladas en este mes: <span class="label label-pink">7</span>
					
				 	     </div>
				 </div>

				 <div class="row">

					      <div class="alert alert-warning m-b-10">
								<strong><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">¡Aviso! </font></font></strong><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Compras por pagar en este mes: <span class="label label-warning">2</span>
					
					
				 	     </div>
				 </div>

				  <div class="row">

					      <div class="alert alert-success m-b-10">
								<strong><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">¡Aviso! </font></font></strong><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Compras pagadas en este mes: <span class="label label-success">2</span>
					
					
				 	     </div>
				 </div> 


				</div>
			</div>

	</div>

	<div class="col-md-7">
		<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title" style="color: #777;">Gráfico de Compras-Meses</h3>
							<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
						</div>
						<div class="panel-body">
							<canvas id="line-chart"  height="150"></canvas>
						</div>
				</div>
	    </div>

</div>

    
</div>

<!---NOTIFICACION DEL STOCK BAJO escuchando Owari no Seraph S2 ED - Orarion - Nagi Yanagi como MOLA -->
<div id="page-notification-container" class="page-notification-container">
@foreach($detalles as $det)
	@if($det->num_stock_gn <= $det->stockmin)

<div class="page-notification  bounceInRight animated page-notification-inverse">
	<div class="notification-media">

		<img src="{{asset('imagenes/variaciones/'.$det->imagen)}}"  class=" zoom">
	</div>
	<div class="notification-info">
		<h4 class="notification-title">{{$det->articulo_com}}</h4>
		<p class="notification-desc">{{$det->num_stock_gn}} {{$det->medida_stock_gn}}(s) con {{$det->num_stock_det}} {{$det->medida_stock_det}}</p>
	</div>
	<div class="notification-btn">
		<a href="" style="cursor:pointer;" data-backdrop="false" data-target="#modal-{{$det->iddetalle_articulo}}" data-toggle="modal" >Proveedor</a>
		<a href="#" data-dismiss="notification">Close</a>
		</div>
</div>
  @include('extras.listado',[$det,$proveedores])
@endif
@endforeach
</div>

@push ('scripts')

<script src="{{asset('assets\plugins\jquery\jquery-1.9.1.min.js')}}"></script>
<script src="{{asset('assets\plugins\chart\chart-js\Chart.min.js')}}"></script>


	<script type="text/javascript">
	new Chart(document.getElementById("line-chart"), {
	type: 'line',
	data: {
		labels: [<?php foreach ($comprasmes as $reg){echo '"'. $reg->mes.'",';} ?>],
		datasets: [{
				data: [<?php foreach ($comprasmes as $reg){echo ''. $reg->totalmes.',';} ?>],
				label: "Compras",
				backgroundColor: '#e5d0ee',
				borderColor: "#b164c8",
				fill: true

			}
		]
	},
	options: {
		title: {
			display: true,
			text: ''
		}
	}
	});
	</script>

	<script type="text/javascript">
	var densityCanvas = document.getElementById("barraschart");

		var densityData = {
		label: 'Total Día',
		data: [<?php foreach ($comprasdias as $cmd){echo '"'. $cmd->totaldia.'",';} ?>],
		backgroundColor: '#bfc2cd',
    hoverBackgroundColor: '#e8403f'
};

		var barChart = new Chart(densityCanvas, {
		type: 'bar',
		data: {
			labels: [<?php foreach ($comprasdias as $cmd){echo '"'. $cmd->dia.'",';} ?>],
			datasets: [densityData],

		},
		options: {
    legend: {
      display: false // Ocultar legendas
    },
    scales: {
      xAxes: [{
        barPercentage:.4,gridLines:{display:!1},
				gridTextSize:10

      }],
      yAxes: [{

				gridLines:{borderDashOffset:8,drawTicks:!1,drawBorder:!1,color:"#dbdce0",borderDash:[4]}
      }]
    }
  }

		});
	</script>
	<script type="text/javascript">

		$(document).on('click', '.panel-heading span.clickable', function(e){
    var $this = $(this);
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	}
})

	</script>
		


 @endpush
@endsection
