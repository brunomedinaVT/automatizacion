<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{


        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(10);
        // Título
        $this->Cell(170,10,'Reporte de Fallas',1,0,'C');
        // Salto de línea
        $this->Ln(20);

        $this->SetFont('Arial','B',12);


}

    // Pie de página
function Footer()
{
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}

require 'ConnBD.php';
$consulta = "SELECT * FROM dht11";
$resultado = $mysqli->query($consulta);

date_default_timezone_set ("America/Argentina/Buenos_Aires");
$date_time0 = date_create(strftime("%F %T "));
$hora = $date_time0->format('H:i:s');
$fecha = $date_time0->format('d-m-Y');

$pdf = new PDF();
$pdf->AliasNBPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',11);
$pdf->Cell(160, 10, 'Fecha de informe: '.$fecha, 0, 0, '', 0);
$pdf->Cell(10, 10, 'Hora: '.$hora, 0, 1, '', 0);
$pdf->Cell(10, 10,utf8_decode('Línea de producción n°: '), 0, 1, '', 0);

    $totalTiempo_1 = $mysqli->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla1))) AS TiempoTotal1 FROM tiempos");
        $row_1 = $totalTiempo_1->fetch_array();
		$total1 = $row_1[0];

    $totalTiempo_2 = $mysqli->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla2))) AS TiempoTotal2 FROM tiempos");
       $row_2 = $totalTiempo_2->fetch_array();
	   $total2 = $row_2[0];

    $totalTiempo_3 = $mysqli->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Falla3))) AS TiempoTotal2 FROM tiempos");
        $row_3 = $totalTiempo_3->fetch_array();
		$total3 = $row_3[0];


$pdf->SetFont('Arial','B',12);
$pdf->Cell(100, 8, utf8_decode('Tiempo total de línea parada debido a cada falla'), 'B', 1, 'L', 0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(40, 8, 'Pieza Faltante', 'B', 0, 'L', 0);
$pdf->Cell(150, 8, $total1, 'B', 1, 'R', 0);
$pdf->Cell(40, 8, 'Pieza Fallida', 'B', 0, 'L', 0);
$pdf->Cell(150, 8, $total2, 'B', 1, 'R', 0);
$pdf->Cell(40, 8, 'Falta de Tiempo', 'B', 0, 'L', 0);
$pdf->Cell(150, 8, $total3, 'B', 1, 'R', 0);

$pdf->Ln(10);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(10, 10, 'ID', 1, 0, 'C', 0);
$pdf->Cell(30, 10, 'Estado', 1, 0, 'C', 0);
$pdf->Cell(25, 10, 'Falla', 1, 0, 'C', 0);
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', 0);
$pdf->Cell(40, 10, 'Fecha', 1, 1, 'C', 0);

$pdf->SetFont('Arial','',10);
while($row = $resultado->fetch_assoc()){
        $pdf->Cell(10, 10, $row['ID'], 1, 0, 'C', 0);
        $pdf->Cell(30, 10, $row['Estado'], 1, 0, 'C', 0);
        $pdf->Cell(25, 10, $row['Falla'], 1, 0, 'C', 0);
        $pdf->Cell(30, 10, $row['Cantidad'], 1, 0, 'C', 0);
        $pdf->Cell(40, 10, $row['Date'], 1, 1, 'C', 0);
}

$pdf->Output();
?>