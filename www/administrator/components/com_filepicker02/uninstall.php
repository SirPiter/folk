<?php
/**
 * @version 1.0.0
 * @package Joomla
 * @subpackage Install Creator - generated uninstall file
 * @author Milton Pfenninger <info@webconstruction.ch>
 * @copyright Copyright (C) 2010 Milton Pfenninger. All rights reserved.
 * @license GNU/GPL
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.
 */

defined('_JEXEC') or die('Restricted access');
function com_uninstall(){
	com_uninstallOriginal();
	
	jimport('joomla.installer.helper');
	$installer = new JInstaller();
	$packages = array("FilePicker"=>array("FilePicker","component"),"Editor Button - Filepicker"=>array("Editor Button - Filepicker","plugin"));
	foreach( $packages as $packagename => $info ){
		$identifier = $info[0];
		$type = $info[1];
		$id = intval(webconGetExtensionId($identifier,$type));
		$error = false;
		if ($identifier!="FilePicker"){
			if (!$id>0){
				/*$color = "#FFD0D0";
				$text  = "$packagename not found.";
				$error = true;*/
			}else{
				if( $installer->uninstall($type,$id,0)){
					$color = "#E0FFE0";
					$text  = "$packagename successfully uninstalled.";
				}else{
					$error = true;
					$color = "#FFD0D0";
					$text  = "ERROR: Could not uninstall the $packagename. Please uninstall manually.";
				}
				webconUninstallerDisplay($text,$color,$error);
			}
		}
	}
}

function webconGetExtensionId($name,$type){
	$field = 'name';
	if ($type=='module'){
		$field = 'module';
	}
	$db =& JFactory::getDBO();
	$query = "SELECT id FROM #__".$type."s WHERE `$field`=".$db->Quote($name).";";
	$db->setQuery($query);
	return $db->loadResult();
}

function webconUninstallerDisplay($text,$color,$error=false){
	$image='images/tick.png';
	if ($error){
		$image='images/publish_x.png';
	}
	echo '<table style="background-color:'.$color.'" width="100%">
		<tr style="height: 30px">
			<td width="50px"><img src="'.$image.'" /></td>
			<td><font size="2"><b>'.$text.'</b></font></td>
		</tr>
	</table>';
}

function com_uninstallOriginal(){};
