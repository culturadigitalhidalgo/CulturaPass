<?php 
/* 
* print normal
* 
* @category print normal
* @author Centro de Cultura Digital del Estado de Hidalgo SC <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Cultura Digital del Estado de Hidalgo SC
* @since Versión 2.0, revisión 2. Abril/2018
* @versión 2.0 
*/

//include_once('conexion.php');

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
        //$img_file = K_PATH_IMAGES.'boleto.jpg';
        //$this->Image($img_file, 0, 0, 112, 130, '', '', '', false, 300, '', false, false, 0);
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
$pdf->SetTitle('Print normal');
$pdf->SetSubject('Print normal');
$pdf->SetKeywords('Print normal - - CIC');

// set default header data
$pdf->SetHeaderData('', '', '', '');


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

$res = explode("/","2051/2052/2053/2054/2055/2056/2057/2058/2059/2060/2061/2062/2063/2064/2065/2066/2067/2068/2069/2070/2071/2072/2073/2074/2075/2076/2077/2078");
foreach ($res as $valor) {
// add a page
$pdf->AddPage();


//$data = array(array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3));
$pdf->SetFont('helvetica', '', 12);
// print colored table

// ---------------------------------------------------------

// define barcode style

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
    'fontsize' => 24,
    'stretchtext' => 2
);

$pdf->write1DBarcode($valor, 'C128A', 101, 110, '', 19, 0.3, $style, 'N');
//horizontal, vertical, vewrtical de la barra, horizontal de la barra

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
    'fontsize' => 24,
    'stretchtext' => 2
);
$pdf->write1DBarcode($valor, 'C128A', 165, 239, '', 19, 0.3, $style, 'N');

// ---------------------------------------------------------




$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
}
//Close and output PDF document
$pdf->Output('Print_normal.pdf', 'I');
?>