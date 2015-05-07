<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class OrganizationsControllerOrganization extends OrganizationsController
{

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply',	'save' );
		$this->registerTask( 'remove_session',	'remove_session' );
		$this->registerTask( 'default',	'setDefault' );
		
	}

	function edit()
	{
		JRequest::setVar( 'view', 'organization' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('organization');
		if ($model->store($post)) {
			$msg = JText::_( 'COM_KONSAEXP_ORGANIZATION_SAVED' );
		} else {
			$msg = JText::_( 'COM_KONSAEXP_ERROR_SAVING_ORGANIZATION' );
		}

		$task = JRequest::getCmd( 'task' );
		$id = JRequest::getVar('id');

		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_konsaexp&controller=organization&task=edit&cid[]='. $id ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_konsaexp&controller=organizations';
				break;
		}

		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		$model = $this->getModel('organization');
		if(!$model->delete()) {
			$msg = JText::_( 'COM_KONSAEXP_ORGANIZATIONS_NOT_DELETED' );
		} else {
			$msg = JText::_( 'COM_KONSAEXP_ORGANIZATIONS_DELETED' );
		}

		$this->setRedirect( 'index.php?option=com_konsaexp&controller=organizations', $msg );
	}

	function cancel()
	{
		$msg = JText::_( 'COM_KONSAEXP_OPERATION_CANCELED' );
		$this->setRedirect( 'index.php?option=com_konsaexp&controller=organizations', $msg );
	}
	
	function remove_session()
	{
		$organization_id = JRequest::getVar('id');
		$model = $this->getModel('organization');
		if(!$model->delete_session()) {
			$msg = JText::_( 'COM_KONSAEXP_ARTISTS_TO_SESSION_NOT_DELETED' );
		} else {
			$msg = JText::_( 'COM_KONSAEXP_ARTISTS_TO_SESSION_DELETED' );
		}
		If ($organization_id) {
			$this->setRedirect( 'index.php?option=com_konsaexp&controller=organization&task=edit&cid[]=' . $organization_id, $msg );
		} else {
			$this->setRedirect( 'index.php?option=com_konsaexp&controller=organizations', $msg );
		}
	}
	
	
	function setDefault(){
		// Check for request forgeries
		$cid = JRequest::getCmd('cid', '');
		$model = $this->getModel('organization');
		if ($model->publish($cid))
		{
			$msg = JText::_('COM_KONSAEXP_MSG_DEFAULT_ORG_SAVED');
			$type = 'message';
		}
		else
		{
			$msg = $this->getError();
			$type = 'error';
		}
		$this->setredirect('index.php?option=com_konsaexp&controller=organizations', $msg);
	}
	
	
		
}