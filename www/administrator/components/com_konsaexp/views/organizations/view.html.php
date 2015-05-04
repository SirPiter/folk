<?php

/**
 * @version		2.5.28
 * @package		konsaexp
 * @copyright	2015 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class OrganizationsViewOrganizations extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(  JText::_( 'COM_KONSAEXP_ORGANIZATION_MANAGER' ), 'organization' );
		JToolBarHelper::makeDefault('installed.setDefault');
		JToolBarHelper::divider();
		
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');

		// Get data from the model

		$items		= & $this->get('Data');
		$pagination = & $this->get('Pagination');
		$keywords = & $this->get('keywords');

		//print_r($items);
		$state =& $this->get('state');	
		//$this->state = $this->get('State');
		
        $lists['organizations_order_Dir'] = $state->get( 'organizations_filter_order_Dir' );
       	$lists['organizations_order']     = $state->get( 'organizations_filter_order' );

		// get list of sections for dropdown filter - oeeuo? ii aoeaai
/*		$javascript = 'onchange="this.form.submit();"';
		$lists['letter'] = "<option value=''>-- ".JText::_( 'COM_KONSAEXP_SELECT_LETTER' )." --</option>";

		for($i = 0; $i < count($letters); $i++){
			if($letters[$i]["letter"] == $letter) $selected = "selected";
			else $selected = "";
			$lists['letter'] .= "<option value='".$letters[$i]["letter"]."' $selected>".$letters[$i]["letter"]."</option>";
		}
		$lists['letter'] = "<select name='letter' ".$javascript.">".$lists['letter']."</select>";
*/

		// push data into the template
       	$this->assignRef('lists', $lists);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('items', $items);
		$this->assignRef('keywords', $keywords);

		parent::display($tpl);
	}
}