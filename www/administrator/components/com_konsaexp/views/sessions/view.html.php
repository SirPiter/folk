<?php

/**
 * @version	2.5.14
 * @package	konsaexp
 * @copyright	2014
 * @license	GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
//require_once(JPATH_COMPONENT.DS.'helpers'.DS.'helpers.php');

class SessionsViewSessions extends JView
{

	function display($tpl = null)
	{

		JToolBarHelper::title(   JText::_( 'COM_KONSAEXP_SESSION_MANAGER' ), 'session' );
		JToolBarHelper::addNewX();
		JToolBarHelper::editListX();
		JToolBarHelper::deleteList();
//		JToolBarHelper::preferences( 'com_konsaexp' , '500', '700');
		
		$document	= & JFactory::getDocument();
		
		// Get data from the model

		$pagination =& $this->get('Pagination');
		$keywords =& $this->get('keywords');
		$collectors = & $this->get('CollectorsList'); // 
		$collector_id = & $this->get('CollectorId');  //
		
		$towns	= & $this->get('TownsData');
		$items =& $this->get('Data');
		
		
		//print_r($this->items); die;

		// push data into the template
		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('keywords', $keywords);
		$this->assignRef('towns',		$towns);
				
		 $state =& $this->get( 'state' );
         $lists['exp_order_Dir'] = $state->get( 'exp_filter_order_Dir' );
         $lists['exp_order']     = $state->get( 'exp_filter_order' );
		

		//cridem els JavaScript
		// убрано мной $document->addScript('components/com_konsaexp/assets/stars.js');

		//cridem el CSS
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		// get list of sections for dropdown filter
		$javascript = 'onchange="this.form.submit();"';
		$lists['chief_collector'] = "<option value='0'>-- ".JText::_( 'COM_KONSAEXP_SELECT_COLLECTOR' )." --</option>";
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