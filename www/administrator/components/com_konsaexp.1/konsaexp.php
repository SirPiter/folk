<?php

/**
 * @version		1.0.0
 * @package		konsa_expeditions
 * @copyright	2010 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

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
				JSubMenuHelper::addEntry(JText::_('Expeditions'), 'index.php?option=com_konsaexp&controller=expeditions', true );
				JSubMenuHelper::addEntry(JText::_('Collectors'), 'index.php?option=com_konsaexp&controller=collectors' );
				JSubMenuHelper::addEntry(JText::_('Phonograms'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('Towns'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Expeditions';
				break;

			case "collectors":
			case "collector":
				JSubMenuHelper::addEntry(JText::_('Expeditions'), 'index.php?option=com_konsaexp&controller=expeditions');
				JSubMenuHelper::addEntry(JText::_('Collectors'), 'index.php?option=com_konsaexp&controller=collectors', true );
				JSubMenuHelper::addEntry(JText::_('Phonograms'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('Towns'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Collectors';
				break;

			case "towns":
			case "town":
				JSubMenuHelper::addEntry(JText::_('Expeditions'), 'index.php?option=com_konsaexp' );
				JSubMenuHelper::addEntry(JText::_('Collectors'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('Phonograms'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('Towns'), 'index.php?option=com_konsaexp&controller=towns', true);
				JSubMenuHelper::addEntry(JText::_('Regions'), 'index.php?option=com_konsaexp&controller=regions' );

				$prefix	= 'Towns';
				break;

			case "regions":
			case "region":
				JSubMenuHelper::addEntry(JText::_('Expeditions'), 'index.php?option=com_konsaexp' );
				JSubMenuHelper::addEntry(JText::_('Collectors'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('Phonograms'), 'index.php?option=com_konsaexp&controller=phonograms' );
				JSubMenuHelper::addEntry(JText::_('Towns'), 'index.php?option=com_konsaexp&controller=towns');
				JSubMenuHelper::addEntry(JText::_('Regions'), 'index.php?option=com_konsaexp&controller=regions', true );

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
				JSubMenuHelper::addEntry(JText::_('Expeditions'), 'index.php?option=com_konsaexp' );
				JSubMenuHelper::addEntry(JText::_('Collectors'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('Phonograms'), 'index.php?option=com_konsaexp&controller=phonograms', true );
				JSubMenuHelper::addEntry(JText::_('Towns'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Phonograms';
				break;

			case "element":
				$prefix	= 'Element';
				break;

			default:
				JSubMenuHelper::addEntry(JText::_('Expeditions'), 'index.php?option=com_konsaexp', true );
				JSubMenuHelper::addEntry(JText::_('Collectors'), 'index.php?option=com_konsaexp&controller=collectors');
				JSubMenuHelper::addEntry(JText::_('Phonograms'), 'index.php?option=com_konsaexp&controller=phonograms');
				JSubMenuHelper::addEntry(JText::_('Towns'), 'index.php?option=com_konsaexp&controller=towns');
				$prefix	= 'Expeditions';
				break;
		}

// Create the controller

$classname	= $prefix.'Controller'.$controller;

$controller	= new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();
