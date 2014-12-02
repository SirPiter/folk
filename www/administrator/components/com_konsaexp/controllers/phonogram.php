<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhonogramsControllerPhonogram extends PhonogramsController{

	function __construct()
	{
		parent::__construct();

		// Register Extra phonograms
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
	}

	function edit()
	{
		JRequest::setVar( 'view', 'phonogram' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
	//	JRequest::setVar('parent_controller', JRequest::getVar("controller"));

		parent::display();
	}


	function save()
	{
		$model = $this->getModel('phonogram');

		if ($expedition_id = $model->store($post)) {
			$msg = JText::_( 'Phonogram Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Phonogram' );
		}
		
		$task = JRequest::getCmd( 'task' );
		$id = JRequest::getVar('id'); // phonogram id
		
		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_konsaexp&controller=phonogram&task=edit&cid[]='. $id ;
				break;

			case 'save':
			default:
		if ($parent_controller=="phonograms" OR $expedition_id=="") {
				$link = 'index.php?option=com_konsaexp&controller=phonograms';
			} else {
				$link = 'index.php?option=com_konsaexp&controller=expedition&task=edit&tab=2&cid[]=' . $expedition_id;
			}
				break;
		}
		
		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		//this function is called only from the expedition form template
		$expedition_id = JRequest::getVar('id');
		
		$model = $this->getModel('phonogram');
		
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Tracks Could not be Deleted' );
		} else {
			$msg = JText::_( 'Phonogram(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=expedition&task=edit&tab=2&cid[]=' . $expedition_id, $msg );
	}

	function cancel()
	{
		$expedition_id = JRequest::getVar('expedition_id'); // expedition_id
		$parent_controller = JRequest::getVar('parent_controller'); // parent_controller
		
		$msg = JText::_( 'Operation Cancelled' );

	//	print_r($parent_controller); die;
		if ($parent_controller=="phonograms" OR $expedition_id=="") {
				$link = 'index.php?option=com_konsaexp&controller=phonograms';
			} else {
				$link = 'index.php?option=com_konsaexp&controller=expedition&task=edit&tab=2&cid[]=' . $expedition_id;
			}

// $link = 'index.php?option=com_konsaexp&controller=expedition&task=edit&tab=2&cid[]=' . $expedition_id;
		$this->setRedirect( $link, $msg );
	}
}