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

class TownsViewTowns extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'COM_KONSAEXP_TOWN_MANAGER' ), 'town' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		// Get data from the model
		$items		= & $this->get('Data');
		$regions	= & $this->get('RegionsData');
		$region_id = & $this->get('RegionId');
		$pagination =& $this->get('Pagination');
		$keywords = & $this->get('keywords');
		
		$state =& $this->get('state');	
		
		//print_r($state);
		
        $lists['towns_order_Dir'] = $state->get( 'towns_filter_order_Dir' );
        $lists['towns_order']     = $state->get( 'towns_filter_order' );

		$this->assignRef('items',		$items);
		$this->assignRef('regions',		$regions);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('keywords', $keywords);

//		print_r($regions); //die;
						
		$javascript = 'onchange="this.form.submit();"';
		$lists['region'] = "<option value='0'>-- ".JText::_( 'Select region' )." --</option>";
			for($i = 0; $i < count($regions); $i++){
			if($regions[$i]["id"] == $region_id) $selected = "selected";
			else $selected = "";
			$lists['region'] .= "<option value='".$regions[$i]["id"]."' $selected>".$regions[$i]["region_name"]."</option>";
		}
		$lists['region'] = "<select name='region' ".$javascript.">".$lists['region']."</select>";
		$this->assignRef('lists', $lists);
		//print_r($lists);

		parent::display($tpl);
	}
}
