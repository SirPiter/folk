<?php

/**
 * @version		1.0.0
 * @package		konsa_expeditions
 * @copyright	2010 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class PhonogramsViewPhonograms extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Phonogram Manager' ), 'phonogram' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		// Get data from the model
		$items		= & $this->get('Data');
		$towns	= & $this->get('TownsData');
		$expeditions	= & $this->get('ExpeditionsData');
		$pagination =& $this->get('Pagination');
		$keywords = & $this->get('keywords');

		$this->assignRef('items',		$items);
		$this->assignRef('towns',		$towns);
		$this->assignRef('expeditions',	$expeditions);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('keywords', $keywords);
		
		$document->addScript('components/com_konsaexp/assets/audio-player/swfobject/swfobject.js');
		$document->addScript('components/com_konsaexp/assets/audio-player/audio-player.js');
		$document->addScript('components/com_konsaexp/assets/audio-player/player.js'); 


		parent::display($tpl);
	}
}
