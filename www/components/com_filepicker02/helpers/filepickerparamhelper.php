<?php
/**
 * @version 0.3.0 Beta
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
		$subDirUser = 0;
		if ($userType==''||empty($userType))$userType = 'guest';
		$userType = str_replace(' ', '', $userType);
		$userType = strtolower($userType);			
		@$params = &JComponentHelper::getParams( 'com_filepicker' );
		if ($userType!='guest'){
			$default = 0;
			$paramArray = $params->toArray();
			if (!isset($paramArray['guestEnable'])){
				$subDirUser = $default;
			}else{
				$subDirUser = intval($params->get($userType.'SubDirUser',$default));
			}
		}
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
		if ($paramName=='RootPath'&&$subDirUser==1){
			$config =& JFactory::getConfig();	
			$secret = $config->getValue( 'config.secret' );
			$userpath = substr(md5($user->id.$secret),0,10).'-'.$user->id;
			jimport('joomla.filesystem.folder');
			$par2 = str_replace('/',DS,$par);
			if (!JFolder::exists(JPATH_ROOT.DS.$par2.DS.'filepicker_users'.DS.$userpath)){
				if (JFolder::create(JPATH_ROOT.DS.$par2.DS.'filepicker_users'.DS.$userpath)){
					jimport('joomla.filesystem.file');
					if (!JFile::exists(JPATH_ROOT.DS.$par2.DS.'filepicker_users'.DS.'index.html')){
						JFile::write(JPATH_ROOT.DS.$par2.DS.'filepicker_users'.DS.'index.html','');					
					}
					if (!JFile::exists(JPATH_ROOT.DS.$par2.DS.'filepicker_users'.DS.$userpath.DS.'index.html')){
						JFile::write(JPATH_ROOT.DS.$par2.DS.'filepicker_users'.DS.$userpath.DS.'index.html','');					
					}
					
				}else{
					die ('File Picker Error: User directory could not be created!');
				}
			}
			$par = $par.'/filepicker_users'.'/'.$userpath;
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
	
	function getParamArray($paramString,$placeholders,$seperators=array("\n",',')){
		for ($i=0;$i<count($seperators)-1;$i++){
			$paramString = str_replace($seperators[0],$seperators[count($seperators)-1],$paramString);
		}
		$retarray = explode($seperators[count($seperators)-1],$paramString);
		for ($i=0;$i<count($retarray);$i++){
			$retarray[$i]=trim($retarray[$i]);
			foreach ($placeholders as $key => $value){
				$retarray[$i] = str_ireplace($key, $value, $retarray[$i]);
			}
		}		
		return $retarray;
	}
}
