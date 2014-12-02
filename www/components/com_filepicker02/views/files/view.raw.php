<?php
/**
 * @version 0.2.0 Beta
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

class FilepickerViewFiles extends JView
{

	function display($tmp = null)
	{
		if (intval(FilepickerParamHelper::getUserParam('Enable'))==0){
			die('access denied');
		}	
		
		$rootpath = FilepickerParamHelper::getUserParam('RootPath');
	
		//init session

		$session = JFactory::getSession();

		//files handling -- start --

		function getFiles($dir, $rootpath){
			if ($dir==''||$dir==null||!isset($dir)){
				$dir = $rootpath;
			}else{
				$dir = $rootpath.DS.$dir;
			}
			jimport('joomla.filesystem.path');			
			$dir = JPath::clean(JPATH_SITE.DS.$dir);
			JPath::check($dir);
			jimport('joomla.filesystem.folder');
			if (!JFolder::exists($dir)){
				return false;
			}
			$List = array();
			$List['dir'] = array();
			$List['dir'] = JFolder::folders($dir);
			$List['file'] = array();	
			$validUploadFEString = FilepickerParamHelper::getUserParam('FileExtensions');
			$validUploadArray = explode(',',$validUploadFEString);
			$validExtensionsArray = array();
			for ($i=0;$i<count($validUploadArray);$i++){
				$validExtensionsArray[] = '.'.trim($validUploadArray[$i]).'$';
			}
			$string = implode('|',$validExtensionsArray);		
			//print_r($validExtensionsArray);
			$List['file'] = JFolder::files($dir,$string);	
			return $List;
		}	

		$dir = $session->get('curdir','','filepicker');
		if (trim($dir)!=''){
			if (substr($dir,-1)!="/")$dir = $dir.'/';		
		}else{
			$dir = '';
		}
		$changedir = JRequest::getVar('chdir','');
		if (trim($changedir)!=''){
			if ($changedir=='root'){
				$dir = "";	
			}else{
				$dir = urldecode($changedir);
				if (substr($dir,-1)!='/'){
					$dir .= '/';
				}
			}
			$session->set('curdir',$dir,'filepicker');
		}
		$currentDir = $dir;
		if ($dir==''){
			$displayDir = 'root';
		}else{
			$displayDir = $dir;			
		}
		$this->assignRef('currentDir', $currentDir);
		$this->assignRef('displayDir', $displayDir);
		
		jimport('joomla.filesystem');
		$serverdir = JPATH_SITE.DS.$rootpath.DS.$dir;
		$serverdir = JPath::clean($serverdir);
		JPath::check($serverdir);
		$this->assignRef('serverdir',$serverdir);
		
		$fileList = getFiles($dir, $rootpath);
		if ($fileList==false){
			$session->set('curdir','','filepicker');
			$filesList = getFiles('',$rootpath);
			if ($fileList==false){
				$fileList = array();
				$fileList['dir'][0]='access denied';
				$fileList['file'][0]='access denied';
			}
		}
		$this->assignRef('dirList', $fileList['dir']);
		$this->assignRef('filesList', $fileList['file']);
		
		//get file images
		$FileImagesString = FilepickerParamHelper::getUserParam('FileImages');
		$FileImagesString = str_replace("\n",",",$FileImagesString);
		$tmparray = explode(',',$FileImagesString);
		$ext = array();
		$mainframe = JFactory::getApplication();
		$add = '';
		if ($mainframe->isAdmin()){
			$add = '../';
		}
		for ($i=0;$i<count($tmparray);$i++){
			$tmparray2 = explode('=',$tmparray[$i]);
			$tmparray2[0]=trim($tmparray2[0]);
			$tmparray2[1]=trim($tmparray2[1]);
			$ext[$tmparray2[0]]=str_ireplace('{ComponentImagesPath}','components/com_filepicker/assets/images/filetypes/',$tmparray2[1]);
			$ext[$tmparray2[0]]=$add.$ext[$tmparray2[0]];
		}
		$this->assignRef('FileImages', $ext);
		
		$DefaultFileImage = FilepickerParamHelper::getUserParam('DefaultFileImage');
		$DefaultFileImage = str_ireplace('{ComponentImagesPath}','components/com_filepicker/assets/images/filetypes/',$DefaultFileImage);
		$DefaultFileImage = $add.$DefaultFileImage;
		$this->assignRef('DefaultFileImage', $DefaultFileImage);
		//file types
		
		$fileTypes = FilepickerParamHelper::getUserParam('FileExtensions');
		$fileTypesArray = explode(',',$fileTypes);
		for ($i=0;$i<count($fileTypesArray);$i++){
			$fileTypesArray[$i]=trim($fileTypesArray[$i]);
		}
		sort($fileTypesArray);
		$fileTypes = implode(', ',$fileTypesArray);
		
		$this->assignRef('fileTypes',$fileTypes);
		
		parent::display($tmp);
		
	}
}
?>