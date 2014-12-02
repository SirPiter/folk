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

class CollectorsViewCollectors extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(  JText::_( 'Collector Manager' ), 'collector' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		// Get data from the model
		$letter = & $this->get('Letter');   // áóêâà äëÿ ïîèñêà
		$letters = & $this->get('LettersList'); // ñïèñîê áóêâ äëÿ ïîèñêà

		$items		= & $this->get('Data');
		$pagination = & $this->get('Pagination');
		$keywords = & $this->get('keywords');

		$state =& $this->get('state');	
        $lists['collectors_order_Dir'] = $state->get( 'collectors_filter_order_Dir' );
        $lists['collectors_order']     = $state->get( 'collectors_filter_order' );

		// get list of sections for dropdown filter - ôèëüòð ïî áóêâàì
		$javascript = 'onchange="this.form.submit();"';
		$lists['letter'] = "<option value=''>-- ".JText::_( 'Select letter' )." --</option>";

		for($i = 0; $i < count($letters); $i++){
			if($letters[$i]["letter"] == $letter) $selected = "selected";
			else $selected = "";
			$lists['letter'] .= "<option value='".$letters[$i]["letter"]."' $selected>".$letters[$i]["letter"]."</option>";
		}
		$lists['letter'] = "<select name='letter' ".$javascript.">".$lists['letter']."</select>";

		$this->assignRef('lists', $lists);

		// push data into the template

		$this->assignRef('pagination', $pagination);
		$this->assignRef('items',		$items);
		$this->assignRef('keywords', $keywords);


		parent::display($tpl);
	}
}