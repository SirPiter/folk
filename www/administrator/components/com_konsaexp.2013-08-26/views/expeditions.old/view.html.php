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
//require_once(JPATH_COMPONENT.DS.'helpers'.DS.'helpers.php');

class ExpeditionsViewExpeditions extends JView
{

	function display($tpl = null)
	{
//		JToolBarHelper::title(   JText::_( 'EXPEDITION_MANAGER' ), 'expedition' );
		JToolBarHelper::title(   JText::_( 'Expedition Manager' ), 'expedition' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::preferences( 'com_konsaexp' , '500', '700');

		$document	= & JFactory::getDocument();
		
		// Get data from the model

		$pagination =& $this->get('Pagination');
		$keywords =& $this->get('keywords');
		$collectors = & $this->get('CollectorsList');
		$collector_id = & $this->get('CollectorId');
		$items =& $this->get('Data');

		// push data into the template
		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('keywords', $keywords);
		
		 $state =& $this->get( 'state' );
         $lists['exp_order_Dir'] = $state->get( 'exp_filter_order_Dir' );
         $lists['exp_order']     = $state->get( 'exp_filter_order' );
		

		//cridem els JavaScript
		// убрано мной $document->addScript('components/com_konsaexp/assets/stars.js');

		//cridem el CSS
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		// get list of sections for dropdown filter
		$javascript = 'onchange="this.form.submit();"';
		$lists['chief_collector'] = "<option value='0'>-- ".JText::_( 'Select collector' )." --</option>";
		//print_r($artists);
		for($i = 0; $i < count($collectors); $i++){
			if($collectors[$i]["id"] == $collector_id) $selected = "selected";
			else $selected = "";
			$lists['chief_collector'] .= "<option value='".$collectors[$i]["id"]."' $selected>".$collectors[$i]["collector_full_name"]."</option>";
		}
		$lists['chief_collector'] = "<select name='chief_collector' ".$javascript.">".$lists['chief_collector']."</select>";

		$this->assignRef('lists', $lists);

		parent::display($tpl);
	}

}