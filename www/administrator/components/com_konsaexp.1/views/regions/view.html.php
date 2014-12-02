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

class RegionsViewRegions extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(  JText::_( 'Region Manager' ), 'region' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		// Get data from the model
		$items		= & $this->get('Data');
//		$regions	= & $this->get('RegionsData');
//		$region_id = & $this->get('RegionId');
		$okrug = & $this->get('Okrug');   
		$okrugs = & $this->get('OkrugsList');
		$pagination =& $this->get('Pagination');
		$keywords = & $this->get('keywords');

		$this->assignRef('items',	   $items);
//		$this->assignRef('regions',	   $regions);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('keywords', $keywords);
		
		$state =& $this->get( 'state' );		
        $lists['order_Dir'] = $state->get( 'filter_order_Dir' );
        $lists['order']     = $state->get( 'filter_order' );

//	print_r($okrugs[0]); //die;
//	print_r($okrug); //die;
						
		$javascript = 'onchange="this.form.submit();"';
		$lists['okrug'] = "<option value=''>-- ".JText::_( 'Select okrug' )." --</option>";
			for($i = 0; $i < count($okrugs); $i++){
				if($okrugs[$i]["okrug"] == $okrug) $selected = "selected";
				else $selected = "";
				$lists['okrug'] .= "<option value='".$okrugs[$i]["okrug"]."' $selected>".$okrugs[$i]["okrug"]."</option>";
			}
		$lists['okrug'] = "<select name='okrug' ".$javascript.">".$lists['okrug']."</select>";
		$this->assignRef('lists', $lists);
//		print_r($lists);

		parent::display($tpl);
	}
}
