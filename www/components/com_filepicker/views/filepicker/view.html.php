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
//import the JView class
jimport('joomla.application.component.view');

class FilepickerViewFilepicker extends JView
{

	function display($tmp = null)
	{	
		$document =& JFactory::getDocument();
		$document->addStyleSheet( FILEPICKER_HTTP_ROOT . '/components/com_filepicker/assets/css/styles.css', 'text/css', null, array() );
		
		//File manager yes / no
		$showFilemanager = true;
		$enterURLText = 'Please select a file or enter an URL.';
		if (intval(FilepickerParamHelper::getUserParam('EnableFilemanager'))==0){
			$showFilemanager = false;
			$enterURLText = 'Please enter a URL.';
		}
		$this->assignRef('enterURLText', $enterURLText);
		$this->assignRef('showFilemanager',$showFilemanager);
		$showFileuploader = true;
		if (intval(FilepickerParamHelper::getUserParam('EnableUploads'))==0){
			$showFileuploader = false;
		}
		$this->assignRef('showFileuploader',$showFileuploader);
		
		//root url
		
		$rootpath = FilepickerParamHelper::getUserParam('RootPath');
		if (substr($rootpath,-1)!='/'){
			$rootpath .= '/';
		}
		$this->assignRef('rooturl', $rootpath);
		
		//get file images
		$FileImagesString = FilepickerParamHelper::getUserParam('FileImages');
		$FileImageString = str_replace("\n",",",$FileImageString);
		$tmparray = explode(',',$FileImagesString);
		$ext = array();
		$mainframe = JFactory::getApplication();
		$add = '';
		/*if ($mainframe->isAdmin()){
			$add = '../';
		}*/
		$fileImageTypes = array();
		for ($i=0;$i<count($tmparray);$i++){
			$tmparray2 = explode('=',$tmparray[$i]);
			$tmparray2[0]=trim($tmparray2[0]);
			$fileImageTypes[] = $tmparray2[0];
			$tmparray2[1]=trim($tmparray2[1]);
			$ext[$tmparray2[0]]=str_ireplace('{ComponentImagesPath}','components/com_filepicker/assets/images/filetypes/',$tmparray2[1]);
			//$ext[$tmparray2[0]]=$add.$ext[$tmparray2[0]];
		}
		$this->assignRef('FileImages', $ext);
		
		$DefaultFileImage = FilepickerParamHelper::getUserParam('DefaultFileImage');
		$DefaultFileImage = str_ireplace('{ComponentImagesPath}','components/com_filepicker/assets/images/filetypes/',$DefaultFileImage);
		$DefaultFileImage = $add.$DefaultFileImage;
		$this->assignRef('DefaultFileImage', $DefaultFileImage);
		
		//file types
		
		$this->assignRef('FileImageTypes',$fileImageTypes);
		
		JHTML::_('behavior.keepalive');	
		parent::display($tmp);
		
	}
}
?>