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

class DocumentsViewDocument extends JView
{

	function display($tpl = null)
	{
		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		$doc		=& $this->get('Data');
		$related	=& $this->get('DocumentsData');
		$towns		=& $this->get('TownsData');
		$expedition	=& $this->get('Expedition');
		$collectors	=& $this->get('CollectorsData');
		//print_r($doc); 
		//print_r($collectors); 
		//die;

		$isNew		= ($doc->id < 1);

		$text = $isNew ? JText::_( 'COM_KONSAEXP_NEW' ) : JText::_( 'COM_KONSAEXP_EDIT' );
		JToolBarHelper::title(   JText::_( 'COM_KONSAEXP_DOCUMENT' ).': <small><small>[ ' . $text.' ]</small></small>','documentedit' );
		//JToolBarHelper::apply();
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
			$doc->add_date = JHTML::_('date', 'now', 'Y-m-d');
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::apply();
			JToolBarHelper::cancel( 'cancel', 'Close' );
			
		}


//	print_r( $expedition); die;

		$this->assignRef('doc',		$doc);
		$this->assignRef('related',	$related);
		$this->assignRef('towns',	$towns);
		$this->assignRef('expedition',	$expedition);
		$this->assignRef('collectors',	$collectors);
		
		parent::display($tpl);
	}
}