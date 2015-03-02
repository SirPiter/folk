<?php

/** 
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */

jimport( 'joomla.application.component.view');

require_once(JPATH_COMPONENT.DS.'libraries'.DS.'fpdf'.DS.'muscolpdf.php');

class ArtistsViewArtists extends JView
{
	function display($tpl = null)
	{
		$mainframe =& JFactory::getApplication();
		
		$document =& JFactory::getDocument();
		$document->setMimeEncoding('application/pdf');

		$albums		= & $this->get( 'PDFData');
		
		$pdf = new MusColPDF();

		$pdf->SetTitle("MusicCollection");
		$pdf->SetFont('arial','',10);
		$pdf->AddPage();
		
		$pdf->posa_data();
		
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(0);
		$pdf->SetLineWidth(.3);
		
		//print the albums
		$pdf->show_albums_list($albums);
		
      	$pdf->Output("MusicCollection" . ".pdf", "I");
	  
	  	exit();		

	}
	
}
?>
