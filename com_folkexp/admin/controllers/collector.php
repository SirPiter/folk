<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class CollectorsControllerCollector extends CollectorsController
{

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
	}

	function edit()
	{
		JRequest::setVar( 'view', 'collector' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('collector');

		if ($model->store($post)) {
			$msg = JText::_( 'COM_KONSAEXP_COLLECTOR_SAVED' );
		} else {
			$msg = JText::_( 'COM_KONSAEXP_ERROR_SAVING_COLLECTOR' );
		}

		$task = JRequest::getCmd( 'task' );
		$id = JRequest::getVar('id');

		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_konsaexp&controller=collector&task=edit&cid[]='. $id ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_konsaexp&controller=collectors';
				break;
		}

		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		$model = $this->getModel('collector');
		if(!$model->delete()) {
			$msg = JText::_( 'COM_KONSAEXP_COLLECTOR_NOT_DELETED' ); // Error: One or More Collectors Could not be Deleted
		} else {
			$msg = JText::_( 'COM_KONSAEXP_COLLECTOR_DELETED' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=collectors', $msg );
	}

	function cancel()
	{
		$msg = JText::_( 'COM_KONSAEXP_OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_konsaexp&controller=collectors', $msg );
	}
}