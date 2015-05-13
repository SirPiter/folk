<?php

/**
 * @version	2.5.28
 * @package	konsaexp
 * @copyright	2015
 * @license	GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class OrganizationsViewOrganization extends JView
{

	function display($tpl = null)
	{
		//cridem el CSS
		$document	= & JFactory::getDocument();
//		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');
		$user		= JFactory::getUser();
		
		$organization	 =& $this->get('Data');
		//print_r($organization); 
//		$related =& $this->get('OrganizationsData');
//		$towns	 =& $this->get('TownsData');
//		$linkedsessions=& $this->get('LinkedSessions');
		
		//print_r($linkedsessions); die;
//		$sessionslist=& $this->get('SessionsList');
		
		$isNew		= ($organization->id < 1);

		$text = $isNew ? JText::_( 'COM_KONSAEXP_NEW' ) : JText::_( 'COM_KONSAEXP_EDIT' );
		JToolBarHelper::title(   JText::_( 'COM_KONSAEXP_ORGANIZATION' ).': <small><small>[ ' . $text.' ]</small></small>','organizationedit' );
		JToolBarHelper::save();

		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::apply();
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('organization',	$organization);
//		$this->assignRef('related',		$related);
//		$this->assignRef('towns',		$towns);
//		$this->assignRef('linkedsessions',		$linkedsessions);
		$this->assignRef('user',		$user);
		
		//Список всех сессий записи
/*		$lists['sessions'] = "<option value=''>-- ".JText::_( 'COM_KONSAEXP_SELECT_SESSION' )." --</option>";
		for($i = 0; $i < count($sessionslist); $i++){
			$lists['sessions'] .= "<option value='".$sessionslist[$i]["id"]."'>".$sessionslist[$i]["session_title"]."</option>";
		}
		$this->assignRef('lists', $lists);
		
		// JS
		$document->addScript('components/com_konsaexp/assets/organization.js');
	*/	
		parent::display($tpl);
	}
}