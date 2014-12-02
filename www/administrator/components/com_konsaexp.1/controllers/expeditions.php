<?php

/**
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ExpeditionsControllerExpeditions extends ExpeditionsController
{

	function __construct()
	{
		parent::__construct();

	}

	// votar amb AJAX

	function rate(){

		$mainframe =& JFactory::getApplication();


		 $id = JRequest::getVar( 'expedition_id');
		 $points = JRequest::getVar( 'points');
		 $model = $this->getModel('expedition');
		 $return = $model->rate($id,$points);

		 echo $return;
		 $mainframe->close();

  }

}