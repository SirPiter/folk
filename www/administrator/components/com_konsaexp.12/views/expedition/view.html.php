<?php

/**
 * @version		1.0.1
 * @package		konsa_expeditions
 * @copyright	2010 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ExpeditionsViewExpedition extends JView
{

	function display($tpl = null)
	{
		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		$expedition		=& $this->get('Data');
		$tracks		=& $this->get('Tracks');
		$collectors		=& $this->get('CollectorsList');
		$towns	=& $this->get('TownsList');
		$townswithregions	=& $this->get('ExtendedTownsList');
		$phonograms		=& $this->get('Phonograms');
		
		
		
		// quina tab del panel mostrar inicialment
		$tab = JRequest::getVar('tab',  0, '');
		$this->assignRef('tab',		$tab);

		$isNew		= ($expedition->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Expedition' ).': <small><small>[ ' . $text.' ]</small></small>','expeditionedit' );
		JToolBarHelper::save();

		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::apply();
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		
		// push data into the template
		$this->assignRef('expedition',	$expedition);
		$this->assignRef('tracks',		$tracks);
		$this->assignRef('collectors',	$collectors);
		$this->assignRef('towns',		$towns);
		$this->assignRef('townswithregions',	$townswithregions);
		$this->assignRef('phonograms',	$phonograms);
		
	//	print_r($townswithregions); die;
		// JS
		$document->addScript('components/com_konsaexp/assets/tracks.js');


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