<?php

/**
 * @version		1.0.0
 * @package		konsaexp
 * @copyright	2010 SP
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
			$msg = JText::_( 'Expedition Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Expedition' );
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
			$msg = JText::_( 'Error: One or More Expeditions Could not be Deleted' );
		} else {
			$msg = JText::_( 'Expedition(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=expedition', $msg );
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_konsaexp&controller=expedition', $msg );
	}
}