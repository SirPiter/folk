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

class ArtistsViewArtists extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(  JText::_( 'COM_KONSAEXP_ARTIST_MANAGER' ), 'artist' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		// Get data from the model
		$letter = & $this->get('Letter');   // aoeaa aey iienea
		$letters = & $this->get('LettersList'); // nienie aoea aey iienea

		$items		= & $this->get('Data');
		$pagination = & $this->get('Pagination');
		$keywords = & $this->get('keywords');

		$state =& $this->get('state');	
        $lists['artists_order_Dir'] = $state->get( 'artists_filter_order_Dir' );
        $lists['artists_order']     = $state->get( 'artists_filter_order' );

		// get list of sections for dropdown filter - oeeuo? ii aoeaai
		$javascript = 'onchange="this.form.submit();"';
		$lists['letter'] = "<option value=''>-- ".JText::_( 'COM_KONSAEXP_SELECT_LETTER' )." --</option>";

		for($i = 0; $i < count($letters); $i++){
			if($letters[$i]["letter"] == $letter) $selected = "selected";
			else $selected = "";
			$lists['letter'] .= "<option value='".$letters[$i]["letter"]."' $selected>".$letters[$i]["letter"]."</option>";
		}
		$lists['letter'] = "<select name='letter' ".$javascript.">".$lists['letter']."</select>";

		$this->assignRef('lists', $lists);

		// push data into the template

		$this->assignRef('pagination', $pagination);
		$this->assignRef('items', $items);
		$this->assignRef('keywords', $keywords);


		parent::display($tpl);
	}
}