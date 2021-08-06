<?php

class dht11{

 public $link='';
 //contructor
 function __construct($estado){ 
  //define variables globales
  $this->connect();
  $this->storeInDB($estado);
  
 }

 
 function connect(){ 

    $mysql_servidor = "localhost";        //localhost
    $mysql_base = "puestos";     //nombre BD
    $mysql_usuario = "root";   //usuario BD
    $mysql_clave = "";        //contraseña BD

  $this->link = mysqli_connect($mysql_servidor,$mysql_usuario,$mysql_clave);
  mysqli_select_db($this->link,$mysql_base) or die('Imposible abrir Base de datos');
 }

 function storeInDB($estado){
     
//ESTADO DE LA LINEA
    $lineaMarcha = "Linea Marcha";      
    $lineaParada = "Linea Detenida";
//TIEMPOS DE FALLAS
    // $query_0 = $this->link->query("SELECT MAX(DATE) FROM dht11 WHERE Falla = 'Sin Fallas'");
    // $row_0 = $query_0->fetch_row();
    // $estado_inicial0 = $row_0[0];
    // $date_time0 = date_create(strftime("%F %T "));

    // //FALLA 1
    //     $query_1 = $this->link->query("SELECT MAX(DATE) FROM dht11 WHERE Falla = 'Falla 1'");
    //     $row1 = $query_1->fetch_row();
    //     $estado_inicial1 = $row1[0];

    //     $date_time1 = date_create($estado_inicial1);
    //     $interval_1 = date_diff($date_time0, $date_time1);
    //     $interval1 = $interval_1->format('%R %H:%I:%S');

    // //FALLA 2
    //     $query_2 = $this->link->query("SELECT MAX(DATE) FROM dht11 WHERE Falla = 'Falla 2'");
    //     $row2 = $query_2->fetch_row();
    //     $estado_inicial2 = $row2[0];
        
    //     $date_time2 = date_create($estado_inicial2);
    //     $interval_2 = date_diff($date_time0, $date_time2);
    //     $interval2 = $interval_2->format('%R %H:%I:%S');

    // //FALLA 3
    //     $query_3 = $this->link->query("SELECT MAX(DATE) FROM dht11 WHERE Falla = 'Falla 3'");
    //     $row3 = $query_3->fetch_row();
    //     $estado_inicial3 = $row3[0];
        
    //     $date_time3 = date_create($estado_inicial3);
    //     $interval_3 = date_diff($date_time0, $date_time3);
    //     $interval3 = $interval_3->format('%R %H:%I:%S');

//TIPO DE FALLA
date_default_timezone_set ("America/Argentina/Buenos_Aires");
    $sinFallas = "Sin Fallas";
    $falla1 = "Falla 1";
    $falla2 = "Falla 2";
    $falla3 = "Falla 3";

    $count1 = $this->link->query("SELECT COUNT(ID) FROM dht11 WHERE Falla = 'Falla 1'"); 
    $row1 = $count1->fetch_row();
    $cantidadFallas1 = $row1[0];
    $count2 = $this->link->query("SELECT COUNT(ID) FROM dht11 WHERE Falla = 'Falla 2'"); 
    $row2 = $count2->fetch_row();
    $cantidadFallas2 = $row2[0];
    $count3 = $this->link->query("SELECT COUNT(ID) FROM dht11 WHERE Falla = 'Falla 3'"); 
    $row3 = $count3->fetch_row();
    $cantidadFallas3 = $row3[0];    

    if ($estado =="0") { //linea en marcha 


        $query = $this->link->query("SELECT * FROM dht11 order by Date desc limit 2 OFFSET 0");
        $row = $query->fetch_row();
        $falla = $row[2];
        $date_time0 = date_create(strftime("%F %T "));
        $date_time1 = date_create($row[4]);
        $interval_1 = date_diff($date_time1, $date_time0);
        $interval1 = $interval_1->format('%R %H:%I:%S');
            if($falla == 'Falla 1'){
                $query = "insert into tiempos (Falla1, Date)     
                values ('".$interval1."',NOW())"; 
                $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
                echo "Se ha cargado el tiempo total de la falla 1. <p>";
            }elseif($falla == 'Falla 2'){
                $query = "insert into tiempos (Falla2, Date)     
                values ('".$interval1."',NOW())"; 
                $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
                echo "Se ha cargado el tiempo total de la falla 2. <p>";
            } elseif($falla == 'Falla 3'){
                $query = "insert into tiempos (Falla3, Date)     
                values ('".$interval1."',NOW())"; 
                $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
                echo "Se ha cargado el tiempo total de la falla 3. <p>";
            }

        $query = "insert into dht11 (Estado , Falla, Cantidad, Date)     
        values ('".$lineaMarcha."','".$sinFallas."','".$sinFallas."',NOW())"; 
        $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
        echo "Se ha cargado el dato en la tabla - Linea Marcha. <p>";
       
    } elseif ($estado == "1") {
        $query = "insert into dht11 (Estado , Falla, Cantidad, Date)     
        values ('".$lineaParada."','".$falla1."','".$cantidadFallas1."',NOW())";  
        $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
        echo "Se ha cargado el dato en la tabla - Linea Detenida debido a la falla 1. <p>";
    
    } elseif ($estado == "2") {
        $query = "insert into dht11 (Estado , Falla, Cantidad, Date)     
        values ('".$lineaParada."','".$falla2."','".$cantidadFallas2."',NOW())"; 
        $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
        echo "Se ha cargado el dato en la tabla - Linea Detenida debido a la falla 2. <p>";
    
    } elseif ($estado == "3") {
        $query = "insert into dht11 (Estado , Falla, Cantidad, Date)     
        values ('".$lineaParada."','".$falla3."','".$cantidadFallas3."',NOW())"; 
        $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
        echo "Se ha cargado el dato en la tabla - Linea Detenida debido a la falla 3. <p>";
    } //fin if - else 

    $totalTiempo1 = $this->link->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla1))) AS TiempoTotal1 FROM tiempos");
        $row1 = $totalTiempo1->fetch_array();
        $total1 = $row1[0];
    $totalTiempo2 = $this->link->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla2))) AS TiempoTotal2 FROM tiempos");
       $row2 = $totalTiempo2->fetch_array();
       $total2 = $row2[0];
    $totalTiempo3 = $this->link->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla3))) AS TiempoTotal2 FROM tiempos");
        $row3 = $totalTiempo3->fetch_array();
        $total3 = $row3[0];


        $date1 = date_create($total1);
        $date_1 = date_format($date1, 'H:i:s');
        $HorasPartes1 = explode(":", $date_1);
        $minutosTotales1= ($HorasPartes1[0] * 60) + $HorasPartes1[1] + ($HorasPartes1[2] / 60);
        $minutosTotales_1 = round( $minutosTotales1, 2, PHP_ROUND_HALF_ODD);
    echo "<br> Tiempo total de Falla 1: <br>" . $total1 . "(H:m:s) <br> Total en minutos: " . $minutosTotales_1 . " minutos.";
        $date2 = date_create($total2);
        $date_2 = date_format($date2, 'H:i:s');
        $HorasPartes2 = explode(":", $date_2);
        $minutosTotales2= ($HorasPartes2[0] * 60) + $HorasPartes2[1] + ($HorasPartes2[2] / 60);    
        $minutosTotales_2 = round( $minutosTotales2, 2, PHP_ROUND_HALF_ODD);
    echo "<br> Tiempo total de Falla 2: <br>" . $total2 . "(H:m:s) <br> Total en minutos: " . $minutosTotales_2 . " minutos.";
        $date3 = date_create($total3);
        $date_3 = date_format($date3, 'H:i:s');
        $HorasPartes3 = explode(":", $date_3);
        $minutosTotales3= ($HorasPartes3[0] * 60) + $HorasPartes3[1] + ($HorasPartes3[2] / 60);
        $minutosTotales_3 = round( $minutosTotales3, 2, PHP_ROUND_HALF_ODD);
    echo "<br> Tiempo total de Falla 3: <br>" . $total3 . "(H:m:s) <br> Total en minutos: " . $minutosTotales_3 . " minutos.";
}
}
//compara los estados recibidos y escribe en tabla - 0: Linea Detenida / 1: Linea Marcha
 if($_POST['estado'] == ""){
    $dht11=new dht11($_POST['estado']);
} else {
    $dht11=new dht11($_POST['estado']);
}

?>