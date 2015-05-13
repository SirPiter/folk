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

class ExpeditionsViewExpedition extends JView
{

	function display($tpl = null)
	{
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		$expedition			=& $this->get('Data');
		$tracks				=& $this->get('Tracks');
		$collectors			=& $this->get('CollectorsList');
		$towns				=& $this->get('TownsList');
		$townswithregions	=& $this->get('ExtendedTownsList');
		$phonograms			=& $this->get('Phonograms');
		$docs				=& $this->get('Docs');		
//		$organization		=& $this->get('Organization');
		$organizations		=& $this->get('Organizations');
		
		
		
		$tab = JRequest::getVar('tab',  0, '');
		$this->assignRef('tab',		$tab);

		$isNew		= ($expedition->id < 1);

		$text = $isNew ? JText::_( 'COM_KONSAEXP_NEW' ) : JText::_( 'COM_KONSAEXP_EDIT' );
		JToolBarHelper::title(   JText::_( 'COM_KONSAEXP_EXPEDITION' ).': <small><small>[ ' . $text.' ]</small></small>','expeditionedit' );
		JToolBarHelper::save();

		if ($isNew)  {
			JToolBarHelper::cancel();
			$params = JComponentHelper::getParams('com_konsaexp');
			$expedition->organization_id = $params->get('Organization');
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::apply();
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
// JToolBarHelper::divider();
// JToolBarHelper::addNew('item.add');
		
		// push data into the template
		$this->assignRef('expedition',	$expedition);
		$this->assignRef('tracks',		$tracks);
		$this->assignRef('collectors',	$collectors);
		$this->assignRef('towns',		$towns);
		$this->assignRef('townswithregions',	$townswithregions);
		$this->assignRef('phonograms',	$phonograms);
		$this->assignRef('docs',	$docs);
		//$this->assignRef('organization',	$organization);
		$this->assignRef('organizations',	$organizations);
		
	//	print_r($organization); 
		
		// JS
		$document->addScript('components/com_konsaexp/assets/tracks.js');
		
//		$this->log->addEntry(array('LEVEL' => '1','STATUS' => 'Expedition','COMMENT' => 'Your message here'));
		//JLog::add('Это сообщения для записи в лог файл');
		JLog::add(JText::_('Открывается форма Экспедиция'), JLog::INFO);


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