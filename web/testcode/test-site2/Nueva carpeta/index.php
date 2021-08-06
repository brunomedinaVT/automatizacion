<?php
	//conexion con sql
	$mysql_servidor = "localhost";        //localhost
	$mysql_base = "puestos";     //nombre BD
	$mysql_usuario = "root";   //usuario BD
	$mysql_clave = "";        //contraseña BD
?>

<!DOCTYPE html>			<!-- Necesario para asegurar que no haya errores -->
<html>
  <head>
    <meta charset="utf-8">  <!-- establece los caracteres que debe usar el documento -->
    <title>Datos de puesto</title>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

	<script language="javascript">
setTimeout(function(){
   window.location.reload(1);
}, 30000);
</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style1.css">
  </head>
  
  <body>					<!-- contiene todo el contenido que se dedea mostrar -->
<?php
$mysqli = new mysqli($mysql_servidor,$mysql_usuario,$mysql_clave,$mysql_base);
	$count1 = $mysqli->query("SELECT COUNT(ID) FROM dht11 WHERE Falla = 'Falla 1'"); 
	$row1 = $count1->fetch_row();
		$cantidadFallas1 = $row1[0];
	$count2 = $mysqli->query("SELECT COUNT(ID) FROM dht11 WHERE Falla = 'Falla 2'"); 
	$row2 = $count2->fetch_row();
		$cantidadFallas2 = $row2[0];
	$count3 = $mysqli->query("SELECT COUNT(ID) FROM dht11 WHERE Falla = 'Falla 3'"); 
	$row3 = $count3->fetch_row();
		$cantidadFallas3 = $row3[0];

	$totalTiempo_1 = $mysqli->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla1))) AS TiempoTotal1 FROM tiempos");
        $row_1 = $totalTiempo_1->fetch_array();
		$total1 = $row_1[0];
		$date1 = date_create($total1);
        $date_1 = date_format($date1, 'H:i:s');
        $HorasPartes1 = explode(":", $date_1);
        $minutosTotales1= ($HorasPartes1[0] * 60) + $HorasPartes1[1] + ($HorasPartes1[2] / 60);
        $minutosTotales_1 = round( $minutosTotales1, 2, PHP_ROUND_HALF_ODD);
    $totalTiempo_2 = $mysqli->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla2))) AS TiempoTotal2 FROM tiempos");
       $row_2 = $totalTiempo_2->fetch_array();
	   $total2 = $row_2[0];
	   $date2 = date_create($total2);
	   $date_2 = date_format($date2, 'H:i:s');
	   $HorasPartes2 = explode(":", $date_2);
	   $minutosTotales2= ($HorasPartes2[0] * 60) + $HorasPartes2[1] + ($HorasPartes2[2] / 60);    
	   $minutosTotales_2 = round( $minutosTotales2, 2, PHP_ROUND_HALF_ODD);
    $totalTiempo_3 = $mysqli->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla3))) AS TiempoTotal2 FROM tiempos");
        $row_3 = $totalTiempo_3->fetch_array();
		$total3 = $row_3[0];
		$date3 = date_create($total3);
        $date_3 = date_format($date3, 'H:i:s');
        $HorasPartes3 = explode(":", $date_3);
        $minutosTotales3= ($HorasPartes3[0] * 60) + $HorasPartes3[1] + ($HorasPartes3[2] / 60);
        $minutosTotales_3 = round( $minutosTotales3, 2, PHP_ROUND_HALF_ODD);
?>

	<h1>Linea aérea de ensamblaje</h1>
	<!-- <img src="images/imagen1.jpg" alt="My test image"> -->

		<table border="3" id="tabla1";>
			<tr>
				 <td colspan="2" >Datos extraídos de base de datos</td>
			</tr>
			<tr>
				<td>Estado</td>
				<td>Fecha</td>
			</tr>
			
			<?php
			$mysqli = new mysqli($mysql_servidor,$mysql_usuario,$mysql_clave,$mysql_base);
			$result = $mysqli->query("SELECT * FROM dht11 order by Date DESC limit 17");
	
			while($mostrar=mysqli_fetch_array($result)){
			?>
			
			<tr>
				<td><?php echo $mostrar['Estado']?></td>
				<td><?php echo $mostrar['Date']?></td>
			</tr>
			<?php
			}
			?>
		</table>

		<ul class="nav nav-tabs" id="myTab" role="tablist">
 			 <li class="nav-item">
 				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Cantidad</a>
 			 </li>
 			 <li class="nav-item">
 			   	<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Tiempos</a>
 			 </li>
		</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
								<div class="card-deck" style="display: flex; width: 45rem; ">
									<div class="card text-white bg-danger mb-6">
										<div class="card-header h5">Piezas faltantes</div>
											<div class="card-body">
											<h5 class="card-title h4"><span id="idpiezaFaltante"> 
											<?php
											echo $cantidadFallas1 = $row1[0];
											?></h5>
											<p id="texto3" class="card-text" style="LINE-HEIGHT:25px">Cantidad de paradas debido a falta de piezas.</p>
										</div>
									</div>
									<div class="card text-white bg-danger mb-6">
										<div class="h5 card-header">Pieza fallida</div>
											<div class="card-body">
											<h5 class="h4 card-title"><span id="idpiezaFallida">
											<?php
											echo $cantidadFallas2 = $row2[0];
											?></h5>
											<p id="texto3" class="card-text" style="LINE-HEIGHT:25px">Cantidad de paradas debido a fallas en piezas.</p>
										</div>
									</div>
									<div class="card text-white bg-danger mb-6">
										<div class="h5 card-header">Falta de tiempo</div>
										<div class="card-body">
											<h5 class="h4 card-title"><span id="idfaltaTiempo">
											<?php
											echo $cantidadFallas3 = $row3[0];
											?></h5>
											<p id="texto3" class="card-text" style="LINE-HEIGHT:25px">Cantidad de paradas debido a falta de tiempo en montaje.</p>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
								<div class="card-deck" style="display: flex; width: 45rem; ">
									<div class="card text-white bg-info mb-6">
										<div class="card-header h5">Piezas faltantes</div>
											<div class="card-body">
											<h5 class="card-title h5"><span id="idpiezaFaltante"> 
											<?php
												echo $total1 . "(h:m:s)";
											?></h5>
											<p id="texto3" class="card-text" style="LINE-HEIGHT:25px">Tiempo total de parada debido a falta de piezas.</p>
										</div>
									</div>
									<div class="card text-white bg-info mb-6">
										<div class="h5 card-header">Pieza fallida</div>
											<div class="card-body">
											<h5 class="h5 card-title"><span id="idpiezaFallida">
											<?php
												echo $total2 . "(h:m:s)";
											?></h5>
											<p id="texto3" class="card-text" style="LINE-HEIGHT:25px">Tiempo total de parada debido a fallas en piezas.</p>
										</div>
									</div>
									<div class="card text-white bg-info mb-6">
										<div class="h5 card-header">Falta de tiempo</div>
										<div class="card-body">
											<h5 class="h5 card-title"><span id="idfaltaTiempo">
											<?php
												echo $total3 . "(h:m:s)";
											?></h5>
											<p id="texto3" class="card-text" style="LINE-HEIGHT:25px">Tiempo total de parada debido a falta de tiempo en montaje.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					
	<!-- <button>Cambiar usuario</button> -->
	<script src="js/index.js"></script>				<!-- Comunicacion con archivo main.js -->
<table id="tabla2" border="3">
	<tr>
	<td id="columna1"><canvas id="grafica1" width="400" height="400"></canvas></td>

	<td id="columna2"><canvas id="grafica2" width="400" height="400"></canvas></td>
	</tr>
</table>
	<script src="js/query.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="js/index.js"></script>
  </body>

  <script>
	let myCanvas= document.getElementById('grafica1').getContext("2d");

	var chart = new Chart (myCanvas,{
		type:"bar",
		data:{
			labels:['FALTANTE DE PIEZA','FALLA PIEZA','OTROS'],
			datasets:[{	
				label:'CANTIDAD Y TIPO DE FALLAS',
				data:[<?php echo $cantidadFallas1 ?>,<?php echo $cantidadFallas2 ?>,<?php echo $cantidadFallas3 ?>],
				backgroundColor: [
				'rgba(250, 0, 0, 0.5)',
				'rgba(0, 250, 0, 0.5)',
				'rgba(0, 0, 250, 0.5)'
								  ]
				}]
			},
			options: {
				responsive: false
			}
			});
	</script>
  <script>
	let myCanvas1= document.getElementById('grafica2').getContext("2d");

	var myPieChart = new Chart(myCanvas1,{
		type:"doughnut",
		data:{
			labels:['FALTANTE DE PIEZA','FALLA PIEZA','OTROS'],
			datasets:[{	
				label:'Tiempos',
				data:[<?php echo $minutosTotales_1 ?>,<?php echo $minutosTotales_2 ?>,<?php echo $minutosTotales_3 ?>],
				backgroundColor: [
				'rgba(250, 0, 0, 0.5)',
				'rgba(0, 250, 0, 0.5)',
				'rgba(0, 0, 250, 0.5)'
								  ]
				}]
			},
			options: {
				responsive: false
			}
			});
	</script>
</html> 