<?php

/**
 * @version	2.5.0
 * @package	konsaexp
 * @copyright	2012
 * @license	GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ArtistsViewArtist extends JView
{

	function display($tpl = null)
	{
		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		$artist		=& $this->get('Data');
		$related		=& $this->get('ArtistsData');
		$towns	=& $this->get('TownsData');

		$isNew		= ($artist->id < 1);

		$text = $isNew ? JText::_( 'COM_KONSAEXP_NEW' ) : JText::_( 'COM_KONSAEXP_EDIT' );
		JToolBarHelper::title(   JText::_( 'COM_KONSAEXP_ARTIST' ).': <small><small>[ ' . $text.' ]</small></small>','artistedit' );
		JToolBarHelper::save();

		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::apply();
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('artist',		$artist);
		$this->assignRef('related',		$related);
		$this->assignRef('towns',		$towns);

		parent::display($tpl);
	}
}