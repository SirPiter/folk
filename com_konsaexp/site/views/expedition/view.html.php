<?php

/**
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ExpeditionsViewExpedition extends JView
{

	function display($tpl = null)
	{
	
		$mainframe =& JFactory::getApplication();
		$pathway	= & $mainframe->getPathway();
		$document	= & JFactory::getDocument();
	
		//cridem el CSS
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');
		$document->addStyleSheet('components/com_konsaexp/assets/style.css');

	
		$expedition		=& $this->get('Data');
		//print_r($this->expedition->chief_collector);
		$tracks			=& $this->get('Tracks');
	//	$collectors		=& $this->get('CollectorsList');
		$collector		=& $this->get('Collector');
		$towns			=& $this->get('TownsList');
		$townswithregions	=& $this->get('ExtendedTownsList');
		$phonograms		=& $this->get('Phonograms');
		
		// quina tab del panel mostrar inicialment
		$tab = JRequest::getVar('tab',  0, '');
		$this->assignRef('tab',		$tab);

		
		// push data into the template
		$this->assignRef('expedition',	$expedition);
		$this->assignRef('tracks',		$tracks);
		$this->assignRef('collector',	$collector);
		$this->assignRef('towns',		$towns);
		$this->assignRef('townswithregions',	$townswithregions);
		$this->assignRef('phonograms',	$phonograms);
		
	//	print_r($townswithregions); die;
		// JS
		$document->addScript('components/com_konsaexp/assets/functions.js');

//		echo "sdfsddsf"; die;

		parent::display($tpl);
	}
    
   	function displayMonth($month){
		$month_array = array(
			1 => "January" , 
			2 => "February" , 
			3 => "March" , 
			4 => "April" , 
			5 => "May" , 
			6 => "June", 
			7 => "July", 
			8 => "August" , 
			9 => "September", 
			10 => "October" , 
			11 => "November", 
			12 => "December"
		);
		return JText::_( $month_array[$month] );
	}
}