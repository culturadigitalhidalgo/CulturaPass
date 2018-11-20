<?php 
/* 
* print Jueces
* 
* @category print Jueces
* @author Centro de Información Cultural del Estado de Hidalgo CECULTAH <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Marzo/2017
* @versión 1.0 
*/

include_once('conexion.php');

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

  
       
  
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'Encabezado.jpg';
		$this->Image($image_file, 10, 12, 192, '', 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);
		// Set font
		//$this->SetFont('helvetica', 'B', 14);
		// Title
		//$this->Cell(0, 15, 'Registro de entrada y salida del personal de Honorarios del "Centro de Información Cultural del Estado de Hidalgo"', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}
	// Colored table
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		$this->SetFillColor(255, 0, 0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(15, 80, 35);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach($data as $row) {
			$this->Cell($w[0], 6, $row[0], 'LR', 0, 'C', $fill);
			$this->Cell($w[1], 6, $row[1], 'LR', 0, 'C', $fill);
			$this->Cell($w[2], 6, $row[2], 'LR', 0, 'C', $fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Innovación Tecnológica y Sistemas - CENTRO DE INFORMACIÓN CULTURAL - SECRETARIA DE CULTURA DE HIDALGO');
$pdf->SetTitle('Resultado ganadores');
$pdf->SetSubject('Resultado ganadores');
$pdf->SetKeywords('Resultado ganadores - - CIC');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins('39', PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 16);

// add a page
$pdf->AddPage();

// Image example with resizing
//$pdf->Image(K_PATH_IMAGES.'img_1.jpg', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -		
$toolcopy = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="'.K_PATH_IMAGES.'img_1.jpg"  width="100" height="100">';
$pdf->writeHTML($toolcopy, true, false, true, false, '');

// print a block of text using Write()


$pdf->Write(0, '                        LISTA DE GANADORES', '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '', '', 0, 'C', true, 0, false, false, 0);

// column titles
$header = array('#', 'Código del PARTICIPANTE', 'Puntaje');

$result = mysql_query("SELECT cbParticipante, ((sazon * 0.4) + (platillo * 0.15) + (participante * 0.15) + (elaboracion * 0.2) + (explicacion * 0.1))total FROM votacion_finales ORDER BY total DESC Limit 5;");
$a=0;
$i = 1;
while ($row = mysql_fetch_row($result)){   
	$tbl[$a][]=$i;
	$tbl[$a][]=$row[0];
    $tbl[$a][]=$row[1];
$i++;
$a++;
}

// data loading
$data = $tbl;
//$data = array(array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3));
$pdf->SetFont('helvetica', '', 12);
// print colored table
$pdf->ColoredTable($header, $data);







//Close and output PDF document
$pdf->Output('Resultado_ganadores.pdf', 'I');

?>
