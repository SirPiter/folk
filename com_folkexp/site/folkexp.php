<?php

/** 
 * @version		1.0.1
 * @package		konsaexp
 * @copyright	2010
 * @license		GPLv2
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');

require_once(JPATH_COMPONENT.DS.'helpers'.DS.'route.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'icon.php');


// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

//print_r($controller);

switch($controller){
	case "expeditions":
		$prefix	= 'Expeditions';
		break;
	case "expedition":
		$prefix	= 'Expeditions';
		break;
	case "collectors":
		$prefix	= 'Collectors';
		break;
	case "collector":
		$prefix	= 'Collectors';
		break;
	case "phonograms":
		$prefix	= 'Phonograms';
		break;
	case "phonogram":
		$prefix	= 'Phonograms';
		break;
	default:
		$prefix	= 'Expeditions';
		break;
}

// Create the controller
//$classname	= 'HellosController'.$controller;
$classname	= $prefix.'Controller'.$controller;

$controller	= new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
		
?>
