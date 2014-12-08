<?php
/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 **/
defined ( '_JEXEC' ) or die ();

/**
 * About view for KonsaExp cpanel
 */
jimport( 'joomla.application.component.view' );
class CpanelViewCpanel extends JView {
	function display($tpl = null) {
		JToolBarHelper::title ( JText::_('COM_KONSAEXP'), 'konsaexp' );

		JToolBarHelper::preferences('com_konsaexp');
		
		parent::display($tpl);
	}
}
