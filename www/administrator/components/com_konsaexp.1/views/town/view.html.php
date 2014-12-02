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

class TownsViewTown extends JView
{

	function display($tpl = null)
	{

		$town		=& $this->get('Data');
		$regions	=& $this->get('RegionsData');
		$towntype_list = & $this->get('TownTypeList');

		$isNew		= ($town->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Town' ).': <small><small>[ ' . $text.' ]</small></small>','townedit' );
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

		$this->assignRef('town',		$town);
		$this->assignRef('regions',		$regions);
		$this->assignRef('towntype_list', $towntype_list);

		parent::display($tpl);
	}
}
