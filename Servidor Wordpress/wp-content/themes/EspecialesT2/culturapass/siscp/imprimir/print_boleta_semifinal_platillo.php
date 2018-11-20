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

$etapa_clasificacion="sf_platillos";
//$etapa_clasificacion="f_platillos";
//$etapa_clasificacion="sf_postres";
//$etapa_clasificacion="f_postres";

$folio_participante="1234";
$nombre="NOEL PÉREZ VÁZQUEZ";
$localidad="Hidalgo, Actopan, Las Mecas";
$nombre_p="Nopales";



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
/*        switch ($etapa_clasificacion) {
            case "sf_platillos":
                $img_file = 'BOLETA_PLATILLOS_SEMIFINAL.jpg';
            case "f_platillos":
                $img_file = 'BOLETA_PLATILLOS_FINAL.jpg';
            case "sf_postres":
                $img_file = 'BOLETA_POSTRES_SEMIFINAL.jpg';
            case "f_postres":
            $img_file = 'BOLETA_POSTRES_FINAL.jpg';
        }



        if($etapa_clasificacion=="sf_platillos")
            $img_file = 'BOLETA_PLATILLOS_SEMIFINAL.jpg';
        else if($etapa_clasificacion=="f_platillos")
            
*/
        $img_file = 'BOLETA_PLATILLOS_SEMIFINAL.jpg';
        $this->Image($img_file, 0, 0, 210, 295, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
	}
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$res = explode("/",$folio_participante);
foreach ($res as $valor) {
// add a page
$pdf->AddPage();



//$data = array(array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3));
$pdf->SetFont('helvetica', '', 16);
$pdf->SetXY(30, 187);
$pdf->Write(8, $nombre, '', 0, 'C', true, 0, false, false, 0);
$pdf->SetXY(30, 195);
$pdf->Write(8, $localidad, '', 0, 'C', true, 0, false, false, 0);
$pdf->SetXY(40, 205);
$pdf->Write(7, $nombre_p, '', 0, 'C', true, 0, false, false, 0);
/*
if($a_pasado=='s')
$pdf->Write(8, 'X', '', 0, 'C', true, 0, false, false, 0);
else
$pdf->Write(8, 'X', '', 0, 'C', true, 0, false, false, 0);
*/
//$pdf->Write(8, 'Juez', '', 0, 'C', true, 0, false, false, 0);
//$pdf->Write(8, 'Juez', '', 0, 'C', true, 0, false, false, 0);
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

$pdf->write1DBarcode($valor, 'C128A', 98, 116, '', 19, 0.3, $style, 'N');
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
$pdf->write1DBarcode($valor, 'C128A', 158, 251, '', 19, 0.3, $style, 'N');

// ---------------------------------------------------------




$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
}
//Close and output PDF document
$pdf->Output('Print_normal.pdf', 'I');
?>