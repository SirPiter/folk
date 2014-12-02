<?php
/**
 * Kunena Component
 * @package Kunena.Administrator
 * @subpackage Views
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

/**
 * About view for Kunena cpanel
 */
jimport( 'joomla.application.component.view' );
class CpanelViewCpanel extends JView {
	function display($tpl = null) {
		JToolBarHelper::title ( JText::_('COM_KONSAEXP'), 'konsaexp' );
		//$this->versioncheck = $this->get('latestversion');

//		if (version_compare(JVERSION, '1.6', '>')) {
//			if (JFactory::getUser()->authorise('core.admin', 'com_konsaexp')) {
//				JToolBarHelper::preferences('com_konsaexp');
//			}
//		}
		
				JToolBarHelper::preferences('com_konsaexp');
		
//		$this->display ();
		parent::display($tpl);
	}
}
