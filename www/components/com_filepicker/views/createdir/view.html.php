<?php
/**
 * @version 1.1.0
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
//import the JView class
jimport('joomla.application.component.view');

class FilepickerViewCreatedir extends JView
{

	function display($tmp = null)
	{	
		$document =& JFactory::getDocument();
		$document->addStyleSheet( FILEPICKER_HTTP_ROOT . 'components/com_filepicker/assets/css/styles.css', 'text/css', null, array() );
		
		
		//check permissions
		
		if (intval(FilepickerParamHelper::getUserParam('EnableCreateDir'))==0){
			JError::raiseError('403',JText::_('Access Forbidden'));
			die('access forbidden');
		}
	
		//if (defined('FILEPICKER_DEMO')&&FilepickerParamHelper::checkIfGuestOrRegistered()){
		if (defined('FILEPICKER_DEMO')){
			parent::display('demo');
			return;
		}
	
		$msg = '';

		$session = JFactory::getSession();

		//get curent dir
		
		$dir = $session->get('curdir','','filepicker');
		if (trim($dir)!=''){
			if (substr($dir,-1)!=DS)$dir .= DS;		
		}else{
			$dir = '';
		}
		
		$dir2 = 'root'.DS.$dir;
		
		$this->assignRef('path',$dir2);
	
		if (JRequest::getVar('createDir','')!=''){
			
			$session = JFactory::getSession();

			$root = trim(FilepickerParamHelper::getUserParam('RootPath'));
			if (substr($root,-1)!=DS)$root .= DS;
			$dir = $root.$dir;

			jimport('joomla.filesystem');
			$dir = JPath::clean(JPATH_SITE.DS.$dir);
			JPath::check($dir);
			
			$folderName = trim(JRequest::getVar('pathname',''));
			if ($folderName==''){
				$msg = 'Folder must have a name!';
			}else{
				JPath::check($dir.$folderName);
				if (JFolder::exists($dir.$folderName)){
					$msg = 'Folder already exists!';
				}else{
					if (JFolder::create($dir.$folderName)){
						$msg = 'Folder '.$folderName.' successfully created.';
					}else{
						$msg = 'There was an error creating the folder named '.$folderName.'!';
					}
				}
			}
		}
		$this->assignRef('msg',$msg);
		parent::display($tmp);		
	}
}
?>
