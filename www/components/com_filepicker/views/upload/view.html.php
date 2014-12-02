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

class FilepickerViewUpload extends JView
{

	function display($tmp = null)
	{	
		//check permissions
		
		if (intval(FilepickerParamHelper::getUserParam('EnableUploads'))==0){
			JError::raiseError('403',JText::_('Access Forbidden'));
			die('access forbidden');
		}
	
		//if (defined('FILEPICKER_DEMO')&&FilepickerParamHelper::checkIfGuestOrRegistered()){
		if (defined('FILEPICKER_DEMO')){
			parent::display('demo');
			return;
		}
	
		$msg = '';

		$validUploadFEString = FilepickerParamHelper::getUserParam('FileExtensionsUpload');
		
		//check if file was uploaded

		if (JRequest::getVar('swfuploaded','')!=''){
			
			$session = JFactory::getSession();

			//get curent dir
			
			$dir = $session->get('curdir','','filepicker');
			if (trim($dir)!=''){
				if (substr($dir,-1)!="/")$dir = $dir.'/';		
			}else{
				$dir = '';
			}
			if ($dir==''||$dir==null||!isset($dir)){
				$dir = 'images';
			}else{
				$dir = 'images'.DS.$dir;
			}
			jimport('joomla.filesystem.path');
			$dir = JPath::clean(JPATH_SITE.DS.$dir);
			JPath::check($dir);
			
			//upload file
			
			$file = JRequest::getVar('swffile', null, 'files', 'array');			 
			//Clean up filename to get rid of strange characters like spaces etc
			
			jimport('joomla.filesystem.file');
			$filename = JFile::makeSafe($file['name']);
				 
			//Set up the source and destination of the file
			
			$src = $file['tmp_name'];
			
			$dest = $dir.DS.$filename;
			
			$checkbox = JRequest::getVar('overwrite','');
			if ($checkbox==''){
				$checkbox = false;
			}else{
				$checkbox = true;
			}
			
			$check = false;
			if (!JFile::exists($dest)||$checkbox==true){
				$check = true;
			}
			$validUploadFileExtensions = explode(',',$validUploadFEString);
			
			if ($check){
				//check if file extension matches
				$doupload = false;
				for ($i=0;$i<count($validUploadFileExtensions);$i++){
					if ( strtolower(JFile::getExt($filename) ) == trim(strtolower($validUploadFileExtensions[$i]))) {
						$doupload = true;
						break;			
					}
				}
				if ($doupload){
					if ( JFile::upload($src, $dest) ) {
						$msg = "File successfully uploaded.";
					}else{
						$msg = "Error by copying file.";
					}
				}else{
					$msg = "File must be $validUploadFEString!";
				}
			}else{
				$msg = "File exists!";
			}
		}
		$fileExtensions = $validUploadFEString;
		$fileTypesArray = explode(',',$fileExtensions);
		for ($i=0;$i<count($fileTypesArray);$i++){
			$fileTypesArray[$i]=trim($fileTypesArray[$i]);
		}
		sort($fileTypesArray);
		$fileExtensions = implode(', ',$fileTypesArray);
		
		$this->assignRef('fileExtensions',$fileExtensions);
		$this->assignRef('msg',$msg);
		parent::display($tmp);		
	}
}
?>