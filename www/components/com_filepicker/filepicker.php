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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

//initialize controller
require_once(JPATH_COMPONENT.DS.'controller.php');
$controller = new FilepickerController();

require_once(JPATH_COMPONENT.DS.'helpers'.DS.'filepickerparamhelper.php');
if (intval(FilepickerParamHelper::getUserParam('Enable'))==0){
	JError::raiseError('403',JText::_('Access Forbidden'));
	die('access forbidden');
}

define('FILEPICKER_HTTP_ROOT',JURI::base());

//run
$controller->execute('display');

//redirect
$controller->redirect();
?>