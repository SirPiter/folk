<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 * Контроллер для реализации сессии записи
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class SessionsControllerSession extends SessionsController
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
		JRequest::setVar( 'view', 'session' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar( 'hidemainmenu', 1);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('session');

		if ($model->store($post)) {
			$msg = JText::_( 'Session Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Session' );
		}

		$task = JRequest::getCmd( 'task' );
		$id = JRequest::getVar('id');

		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_konsaexp&controller=session&task=edit&cid[]='. $id ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_konsaexp&controller=session';
				break;
		}


		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		$model = $this->getModel('session');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Sessions Could not be Deleted' );
		} else {
			$msg = JText::_( 'Session(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=session', $msg );
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_konsaexp&controller=session', $msg );
	}
}