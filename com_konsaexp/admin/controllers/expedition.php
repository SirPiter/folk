<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ExpeditionsControllerExpedition extends ExpeditionsController
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
		JRequest::setVar( 'view', 'expedition' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('expedition');

		if ($model->store($post)) {
			$msg = JText::_( 'COM_KONSAEXP_EXPEDITION_SAVED' );
		} else {
			$msg = JText::_( 'COM_KONSAEXP_EXPEDITION_NOT_SAVED' );
		}

		$task = JRequest::getCmd( 'task' );
		$id = JRequest::getVar('id');

		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_konsaexp&controller=expedition&task=edit&cid[]='. $id ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_konsaexp&controller=expedition';
				break;
		}


		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		$model = $this->getModel('expedition');
		if(!$model->delete()) {
			$msg = JText::_( 'COM_KONSAEXP_EXPEDITION_NOT_DELETED' );
		} else {
			$msg = JText::_( 'COM_KONSAEXP_EXPEDITION_NOT_DELETED' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=expedition', $msg );
	}

	function cancel()
	{
		$msg = JText::_( 'COM_KONSAEXP_OPERATION_CANCELED' );
		$this->setRedirect( 'index.php?option=com_konsaexp&controller=expedition', $msg );
	}
}