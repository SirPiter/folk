<?php

/**
 * @version	2.0.0
 * @package	konsa_expeditions
 * @copyright	2012 SP
 * @license	GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import joomla controller library 2.5
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by HelloWorld
//$controller = JController::getInstance('KonsaExp');

// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );

// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {

	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

		switch($controller){
			case "expeditions":
			case "expedition":
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_EXPEDITIONS'), 'index.php?option=com_konsaexp&controller=expeditions', true );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_COLLECTORS'), 'index.php?option=com_konsaexp&controller=collectors' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_PHONOGRAMS'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_DOCUMENTS'), 'index.php?option=com_konsaexp&controller=documents');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_TOWNS'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Expeditions';
				break;

			case "collectors":
			case "collector":
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_EXPEDITIONS'), 'index.php?option=com_konsaexp&controller=expeditions');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_COLLECTORS'), 'index.php?option=com_konsaexp&controller=collectors', true );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_PHONOGRAMS'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_DOCUMENTS'), 'index.php?option=com_konsaexp&controller=documents');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_TOWNS'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Collectors';
				break;

			case "towns":
			case "town":
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_EXPEDITIONS'), 'index.php?option=com_konsaexp&controller=expeditions' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_COLLECTORS'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_PHONOGRAMS'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_DOCUMENTS'), 'index.php?option=com_konsaexp&controller=documents');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_TOWNS'), 'index.php?option=com_konsaexp&controller=towns', true);
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_REGIONS'), 'index.php?option=com_konsaexp&controller=regions' );

				$prefix	= 'Towns';
				break;

			case "regions":
			case "region":
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_EXPEDITIONS'), 'index.php?option=com_konsaexp&controller=expeditions' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_COLLECTORS'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_PHONOGRAMS'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_DOCUMENTS'), 'index.php?option=com_konsaexp&controller=documents');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_TOWNS'), 'index.php?option=com_konsaexp&controller=towns');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_REGIONS'), 'index.php?option=com_konsaexp&controller=regions', true );

				$prefix	= 'Regions';
				break;

//			case "song":
//				$prefix	= 'Songs';
//				break;
		
			case "track":
				$prefix	= 'Tracks';
				break;
				
			case "phonograms":
			case "phonogram":
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_EXPEDITIONS'), 'index.php?option=com_konsaexp&controller=expeditions' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_COLLECTORS'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_PHONOGRAMS'), 'index.php?option=com_konsaexp&controller=phonograms', true );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_DOCUMENTS'), 'index.php?option=com_konsaexp&controller=documents');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_TOWNS'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Phonograms';
				break;

			case "documents":
			case "document":
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_EXPEDITIONS'), 'index.php?option=com_konsaexp&controller=expeditions' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_COLLECTORS'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_PHONOGRAMS'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_DOCUMENTS'), 'index.php?option=com_konsaexp&controller=documents', true);
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_TOWNS'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Documents';
				break;

			case "element":
				$prefix	= 'Element';
				break;

			default:
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_EXPEDITIONS'), 'index.php?option=com_konsaexp', true );
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_COLLECTORS'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_PHONOGRAMS'), 'index.php?option=com_konsaexp&controller=phonograms');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_DOCUMENTS'), 'index.php?option=com_konsaexp&controller=documents');
				JSubMenuHelper::addEntry(JText::_('COM_KONSAEXP_TOWNS'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Cpanel';
				break;
		}

// Create the controller


$classname	= $prefix.'Controller'.$controller;
//print_r($classname); die;

$controller	= new $classname( );   // старая строчка
//$controller = JController::getInstance($prefix);  // joomla 2.5
 

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();
