<?php 
/* 
* print Jueces
* 
* @category print Jueces
* @author Centro de Cultura Digital del Estado de Hidalgo SC <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Cultura Digital del Estado de Hidalgo SC
* @since Versión 2.0, revisión 2. Abril/2018
* @versión 2.0 
*/

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

// create new PDF document
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
        //$img_file = K_PATH_IMAGES.'Gafetes.png';
        //$this->Image($img_file, 0, 0, 112, 130, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
	}
}
$pdf = new MYPDF('', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Innovación Tecnológica y Sistemas - CENTRO DE INFORMACIÓN CULTURAL - SECRETARIA DE CULTURA DE HIDALGO');
$pdf->SetTitle('Print Jueces');
$pdf->SetSubject('Print Jueces');
$pdf->SetKeywords('Print Jueces - - CIC');

// set default header data
$pdf->SetHeaderData('', '', '', '');


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------


$res = explode("/","0151/0152/0153/0154/0155/0156/0157/0158/0159/0160/0161/0162/0163/0164/0165/0166/0167/0168/0169/0170/0171/0172/0173/0174/0175/0176/0177/0178/0179/0180/0181/0182/0183/0184/0185/0186/0187/0188/0189/0190/0191/0192/0193/0194/0195/0196/0197/0198/0199/0200/0201/0202/0203/0204/0205/0206/0207/0208/0209/0210/0211/0212/0213/0214/0215/0216/0217/0218/0219/0220/0221/0222/0223/0224/0225/0226/0227/0228/0229/0230/0231/0232/0233/0234/0235/0236/0237/0238/0239/0240/0241/0242/0243/0244/0245/0246/0247/0248/0249/0250/0251/0252/0253/0254/0255/0256/0257/0258/0259/0260/0261/0262/0263/0264/0265/0266/0267/0268/0269/0270/0271/0272/0273/0274/0275/0276/0277/0278/0279/0280/0281/0282/0283/0284/0285/0286/0287/0288/0289/0290/0291/0292/0293/0294/0295/0296/0297/0298/0299/0300");
foreach ($res as $valor) {
// add a page
$pdf->AddPage('P',array(136,105));
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
//$img_file = K_PATH_IMAGES.'Gafetes.png';
//$pdf->Image($img_file, 0, 0, 112, 130, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();
//$pdf->setImageScale(2);
$pdf->SetTextColor(217,26,93);



//$data = array(array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3), array(1, 2, 3));
$pdf->SetFont('helvetica', 'B', 35);
$pdf->Write(8, '', '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(8, '', '', 0, 'C', true, 0, false, false, 0);
//$pdf->Write(8, 'Juez', '', 0, 'C', true, 0, false, false, 0);

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
    'fontsize' => 35,
    'stretchtext' => 4
);

//$pdf->write1DBarcode($valor, 'C128A', 164, 113, '', 17, 0.2, $style, 'N');
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->write1DBarcode($valor, 'C128A', 33, 80, '', 30, 0.4, $style, 'N');

// ---------------------------------------------------------



$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
}
//Close and output PDF document
$pdf->Output('Print_jueces.pdf', 'I');
?>
