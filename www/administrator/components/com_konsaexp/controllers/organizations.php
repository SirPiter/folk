<?php

/**
 * @version		2.5.28
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 */


// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class OrganizationsControllerOrganizations extends OrganizationsController
{

	function __construct()
	{
		parent::__construct();
		$this->registerTask( 'default', 	'setDefault' );

	}

	function setDefault(){
		$params = JComponentHelper::getParams('com_konsaexp');
//		$params->set("Default", $cid);
		die;
	}
	
	
}