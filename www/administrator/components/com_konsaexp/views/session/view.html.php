<?php

/**
 * @version		2.5.1
 * @package		konsa_expeditions
 * @copyright	2013 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class SessionsViewSession extends JView
{
	
//	protected $form;
//	protected $item;
//	protected $state;
	
	/** Display the view */
	function display($tpl = null)
	{
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		
		// Initialiase variables.
		$data		=& $this->get('Data'); // Данные самой сессии записи
//		$collectors		=& $this->get('CollectorsList');
	//	$towns			=& $this->get('TownsList');
		$townswithregions	=& $this->get('ExtendedTownsList'); // Список городов с регионами
		$phonograms		=& $this->get('Phonograms'); // Фонограммы  этой сессии
		$docs			=& $this->get('Docs');	// Документы этой сессии
		$peoples		=& $this->get('Peoples');	// Участники этой сессии	
		
		$tab = JRequest::getVar('tab',  0, '');
		$this->assignRef('tab',		$tab);

		$isNew		= ($data->id < 1);
		$text = $isNew ? JText::_( 'COM_KONSAEXP_NEW' ) : JText::_( 'COM_KONSAEXP_EDIT' );
		JToolBarHelper::title(   JText::_( 'COM_KONSAEXP_SESSION' ).': <small><small>[ ' . $text.' ]</small></small>','sessionedit' );
		JToolBarHelper::save();

		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::apply();
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
// JToolBarHelper::divider();
// JToolBarHelper::addNew('item.add');
		
		// push data into the template
		$this->assignRef('data',	$data);
	//	$this->assignRef('collectors',	$collectors);
		//$this->assignRef('towns',		$towns);
		$this->assignRef('townswithregions',	$townswithregions);
		$this->assignRef('phonograms',	$phonograms);
		$this->assignRef('docs',	$docs);
		$this->assignRef('peoples',	$peoples);
		
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