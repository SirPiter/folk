<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class RegionsControllerRegion extends RegionsController
{

	function __construct()
	{
		parent::__construct();
		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
	}

	function edit()
	{
		JRequest::setVar( 'view', 'region' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('region');

		if ($model->store($post)) {
			$msg = JText::_( 'Region Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Region' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_konsaexp&controller=regions';
		$this->setRedirect($link, $msg);
	}
	
	function saveorder(){
		
		$model = $this->getModel('region');
		if(!$model->saveorder()) {
			$msg = JText::_( 'Error saving order' );
		} else {
			$msg = JText::_( 'Order saved' );
		}

		$this->setRedirect( 'index.php?option=com_konsa_exp&controller=regions', $msg );
	}


	function remove()
	{
		$model = $this->getModel('region');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Regions Could not be Deleted' );
		} else {
			$msg = JText::_( 'Region(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_konsa_exp&controller=regions', $msg );
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_konsaexp&controller=regions', $msg );
	}
}
