<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class TracksControllerTrack extends TracksController{

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
	}

	function edit()
	{
		JRequest::setVar( 'view', 'track' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}


	function save()
	{
		$model = $this->getModel('track');

		if ($expedition_id = $model->store($post)) {
			$msg = JText::_( 'Track Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Track' );
		}
		
		$task = JRequest::getCmd( 'task' );
		$id = JRequest::getVar('id'); // song id
		
		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_konsaexp&controller=track&task=edit&cid[]='. $id ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_konsaexp&controller=expedition&task=edit&tab=1&cid[]=' . $expedition_id;
				break;
		}

		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		//this function is called only from the expedition form template
		$expedition_id = JRequest::getVar('id');
		
		$model = $this->getModel('track');
		
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Tracks Could not be Deleted' );
		} else {
			$msg = JText::_( 'Track(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=expedition&task=edit&tab=1&cid[]=' . $expedition_id, $msg );
	}

	function cancel()
	{
		$expedition_id = JRequest::getVar('expedition_id'); // song id

		$msg = JText::_( 'Operation Cancelled' );
		$link = 'index.php?option=com_konsaexp&controller=expedition&task=edit&tab=1&cid[]=' . $expedition_id;
		$this->setRedirect( $link, $msg );
	}
}