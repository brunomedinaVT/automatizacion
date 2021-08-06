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

//TIPO DE FALLA

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

        date_default_timezone_set ("America/Argentina/Buenos_Aires");
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

        echo "<br> Tiempo total de Falla 1: <br>" . $total1 . "(H:m:s)";
        echo "<br> Tiempo total de Falla 2: <br>" . $total2 . "(H:m:s)";
        echo "<br> Tiempo total de Falla 3: <br>" . $total3 . "(H:m:s)";
    }
}
//compara los estados recibidos y escribe en tabla - 0: Linea Detenida / 1: Linea Marcha
    if($_GET['estado'] == ""){
        $dht11=new dht11($_GET['estado']);
    } else {
        $dht11=new dht11($_GET['estado']);
    }

?>