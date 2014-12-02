<?php

/**
 * @version		2.5.4
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhotosControllerPhoto extends PhotosController
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
		JRequest::setVar( 'view', 'photo' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('photo');

		if ($model->store($post)) {
			$msg = JText::_( 'COM_KONSAEXP_PHOTO_SAVED' );
		} else {
			$msg = JText::_( 'COM_KONSAEXP_PHOTO_SAVE_ERROR' );
		}

		$task = JRequest::getCmd( 'task' );
		$id = JRequest::getVar('id');

		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_konsaexp&controller=photo&task=edit&cid[]='. $id ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_konsaexp&controller=photos';
				break;
		}

		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		$model = $this->getModel('photo');
		if(!$model->delete()) {
			$msg = JText::_( 'COM_KONSAEXP_PHOTO_DELETE_ERROR' );
		} else {
			$msg = JText::_( 'COM_KONSAEXP_PHOTO_CANCEL' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=photos', $msg );
	}

	function cancel()
	{
		$msg = JText::_( 'COM_KONSAEXP_OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_konsaexp&controller=photos', $msg );
	}
}