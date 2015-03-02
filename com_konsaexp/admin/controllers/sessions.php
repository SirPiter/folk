<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class SessionsControllerSessions extends SessionsController
{

	function __construct()
	{
		parent::__construct();

	}

	// votar amb AJAX

	function rate(){

		$mainframe =& JFactory::getApplication();


		 $id = JRequest::getVar( 'session_id');
		 $points = JRequest::getVar( 'points');
		 $model = $this->getModel('session');
		 $return = $model->rate($id,$points);

		 echo $return;
		 $mainframe->close();

  }

}