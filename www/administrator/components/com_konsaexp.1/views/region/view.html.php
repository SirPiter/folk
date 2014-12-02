<?php

/**
 * @version		1.0.1
 * @package		muscol
 * @copyright	2009 JoomlaMusicSolutions.com
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class RegionsViewRegion extends JView
{

	function display($tpl = null)
	{

		$region		=& $this->get('Data');
//		$regions	=& $this->get('RegionsData');
//		$towntype_list = & $this->get('TownTypeList');

		$isNew		= ($region->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Region' ).': <small><small>[ ' . $text.' ]</small></small>','regionedit' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		//if($town->display_group == 0) $town->display_group = $town->id;

		$this->assignRef('region',		$region);
//		$this->assignRef('regions',		$regions);
//		$this->assignRef('towntype_list', $towntype_list);

		parent::display($tpl);
	}
}
