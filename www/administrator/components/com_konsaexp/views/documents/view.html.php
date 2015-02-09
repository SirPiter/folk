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

class DocumentsViewDocuments extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(  JText::_( 'COM_KONSAEXP_DOCUMENT_MANAGER' ), 'document' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');
		$document->addStyleSheet ( JUri::base(true).'/components/com_konsaexp/media/css/layout.css' );
		$document->addStyleSheet ( JUri::base(true).'/components/com_konsaexp/media/css/styles.css' );

		// Get data from the model
		$letter = & $this->get('Letter');   // буква для поиска
		$letters = & $this->get('LettersList'); // список букв для поиска

		$items		= & $this->get('Data');
		$pagination = & $this->get('Pagination');
		$keywords = & $this->get('keywords');
		
		//print_r($items); die;

		$state =& $this->get('state');	
        $lists['documents_order_Dir'] = $state->get( 'documents_filter_order_Dir' );
        $lists['documents_order']     = $state->get( 'documents_filter_order' );

		// get list of sections for dropdown filter - фильтр по буквам
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