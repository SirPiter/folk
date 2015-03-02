<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TownsControllerTown extends TownsController
{

	function __construct()
	{
		parent::__construct();
		
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
	}

	function edit()
	{
		JRequest::setVar( 'view', 'town' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('town');

		if ($model->store($post)) {
			$msg = JText::_( 'Town Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Town' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_konsaexp&controller=towns';
		$this->setRedirect($link, $msg);
	}
	
	function saveorder(){
		
		$model = $this->getModel('town');
		if(!$model->saveorder()) {
			$msg = JText::_( 'Error saving order' );
		} else {
			$msg = JText::_( 'Order saved' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=towns', $msg );
	}


	function remove()
	{
		$model = $this->getModel('town');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Towns Could not be Deleted' );
		} else {
			$msg = JText::_( 'Town(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=towns', $msg );
	}

	function cancel()
	{
		$msg = JText::_( 'COM_KONSAEXP_OPERATION_CANCELED' );
		$this->setRedirect( 'index.php?option=com_konsaexp&controller=towns', $msg );
	}
}
