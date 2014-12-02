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

class FilepickerParamHelper{
	
	function getuserparam($paramName){
		//check if from admin		
		$user =& JFactory::getUser();
		$userType = $user->usertype;
		if ($userType==''||empty($userType))$userType = 'guest';
		$userType = str_replace(' ', '', $userType);
		$userType = strtolower($userType);			
		@$params = &JComponentHelper::getParams( 'com_filepicker' );
		if ($paramName!='RootPath'&&$paramName!='FileExtensions'&&$paramName!='FileExtensionsUpload'&&$paramName!='FileImages'&&$paramName!='DefaultImage'){
			if ($userType=='guest'||$userType=='registered'){
				$default = 0;
			}else{
				$default = 1;
			}
		}elseif ($paramName=='RootPath'){
			$default = 'images';
		}elseif ($paramName=='FileExtensions'||$paramName=='FileExtensionsUpload'){
			$default = 'ai,csv,doc,exe,fla,flv,gif,gzip,htm,html,xhtml,indd,jpg,mp3,odp,ods,odt,pdf,png,ppt,psd,rtf,swf,tar,ttf,xcf,xls,zip,gz';
		}
		$paramArray = $params->toArray();
		//Configuration not saved yet	
		if ($paramName == 'FileImages'){
			$default = 'ai={ComponentImagesPath}ai.gif,csv={ComponentImagesPath}csv.gif,doc={ComponentImagesPath}doc.gif,exe={ComponentImagesPath}exe.gif,fla={ComponentImagesPath}fla.gif,flv={ComponentImagesPath}flv.gif,gif={ComponentImagesPath}gif.gif,gzip={ComponentImagesPath}gzip.gif,htm={ComponentImagesPath}htm.gif,html={ComponentImagesPath}htm.gif,xhtml={ComponentImagesPath}htm.gif,jpg={ComponentImagesPath}jpg.gif,indd={ComponentImagesPath}indd.gif,mp3={ComponentImagesPath}mp3.gif,odp={ComponentImagesPath}odp.gif,ods={ComponentImagesPath}ods.gif,odt={ComponentImagesPath}odt.gif,pdf={ComponentImagesPath}pdf.gif,png={ComponentImagesPath}png.gif,ppt={ComponentImagesPath}ppt.gif,psd={ComponentImagesPath}psd.gif,rtf={ComponentImagesPath}rtf.gif,swf={ComponentImagesPath}swf.gif,tar={ComponentImagesPath}tar.gif,ttf={ComponentImagesPath}ttf.gif,xcf={ComponentImagesPath}xcf.gif,zip={ComponentImagesPath}zip.gif,gz={ComponentImagesPath}gz.gif';
			if (!isset($paramArray['guestEnable'])){
				return $default;
			}else{
				return $params->get($paramName,$default);
			}
		}elseif ($paramName == 'DefaultFileImage'){
			$default = '{ComponentImagesPath}default.gif';
			if (!isset($paramArray['guestEnable'])){
				return $default;
			}else{
				return $params->get($paramName,$default);
			}
		}
		
		if (!isset($paramArray['guestEnable'])){
			$par = $default;
		}else{
			$par = $params->get($userType.$paramName,$default);		
		}
		return $par;
	}
	
	function checkIfGuestOrRegistered(){
		$user =& JFactory::getUser();
		$userType = $user->usertype;
		if ($user->guest){
			return true;
		}
		if ($userType=='registered'){
			return true;
		}
		return false;
	}
}
