<?php 
/* 
* print finalistas
* 
* @category print finalistas
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
	//Page header
	public function Header() {
		
		// set bacground image
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = K_PATH_IMAGES.'desprendibles_Page_2.jpg';
        $this->Image($img_file, 0, 0, 210, 300, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
	}
}
$pdf = new MYPDF('', PDF_UNIT, '', false, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Innovación Tecnológica y Sistemas - CENTRO DE INFORMACIÓN CULTURAL - SECRETARIA DE CULTURA DE HIDALGO');
$pdf->SetTitle('Print finalistas');
$pdf->SetSubject('Print finalistas');
$pdf->SetKeywords('Print finalistas - - CIC');

// set default header data
$pdf->SetHeaderData('', '', '', '');


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

$res = explode("/","M01P01/M01P02/M01P03/M01P04/M01P05/M02P06/M02P07/M02P08/M02P09/M02P10/M03P11/M03P12/M03P13/M03P14/M03P15/M04P16/M04P17/M04P18/M04P19/M04P20/M05P21/M05P22/M05P23/M05P24/M05P25/M06P26/M06P27/M06P28/M06P29/M06P30/M07P31/M07P32/M07P33/M07P34/M07P35/M08P36/M08P37/M08P38/M08P39/M08P40/M09P41/M09P42/M09P43/M09P44/M09P45/M10P46/M10P47/M10P48/M10P49/M10P50/M__P51/M__P52/M__P53/M__P54/M__P55");
foreach ($res as $valor) {
// add a page
$pdf->AddPage();
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$img_file = K_PATH_IMAGES.'desprendibles_Page_2.jpg';
$pdf->Image($img_file, 0, 0, 210, 300, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
//$pdf->setImageScale(2);
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(217,26,93);

//$data = array(array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3));
$pdf->SetFont('helvetica', '', 12);
// print colored table

// ---------------------------------------------------------

// define barcode style
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 12,
    'stretchtext' => 4
);

$pdf->write1DBarcode($valor, 'C128A', 165, 111, '', 17, 0.2, $style, 'N');
$pdf->write1DBarcode($valor, 'C128A', 157, 255, '', 17, 0.2, $style, 'N');

// ---------------------------------------------------------




$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
}
//Close and output PDF document
$pdf->Output('Print_finalistas.pdf', 'I');
?>
