<?php
/**
 * @version 0.1.0 Beta
 * @package Joomla
 * @subpackage FilePicker
 * @author Milton Pfenninger <info@webconstruction.ch>
 * @copyright Copyright (C) 2009 Milton Pfenninger. All rights reserved.
 * @license GNU/GPL
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');
$tmpl = JRequest::getVar('tmpl','');
$view = JRequest::getVar('view','');

//Loads from frontend

$backendEditing = false;

if ($tmpl=='component'||$view=='settings'||$view=='files'||$view=='preview'||$view=='upload'){
	$backendEditing = true;
}

if ($backendEditing){
   require_once (JPATH_COMPONENT_SITE.DS.'controller.php');
   $controller = new FilepickerController();
   require_once(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'filepickerparamhelper.php');
   if (intval(FilepickerParamHelper::getUserParam('Enable'))==0){
      JError::raiseError('403',JText::_('Access Forbidden'));
      die('access forbidden');
   }
   $controller->addViewPath(JPATH_COMPONENT_SITE.DS.'views');
   $controller->addModelPath(JPATH_COMPONENT_SITE.DS.'models');
   $controller->execute('backendDisplay');
}else{

//Loads from backend

   require_once (JPATH_COMPONENT.DS.'controller.php');
   $controller = new AdminFilepickerController();
   $controller->execute(JRequest::getVar('task','display'));
}

// Redirect
$controller->redirect();