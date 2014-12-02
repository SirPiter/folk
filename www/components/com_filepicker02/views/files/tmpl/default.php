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

function format_bytes($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}


$dirpath = explode('/',$this->currentDir);
$dirpathString = '<a href="javascript:loadDirectory(\'root\')">root</a>/';
$path = '';
foreach ($dirpath as $fragment){
	if (trim($fragment)!=''){
		$path .= $fragment.'/';
		$dirpathString .= '<a href="javascript:loadDirectory(\''.$path.'\')">'.$fragment.'</a>/';
	}
}
?>
<div style="display:none" id="currentdir"><?php echo $this->currentDir;?></div>
<div id="dirs">
<p><strong>Change directory: <?php echo $dirpathString;?></strong></p>
<?php if (count($this->dirList)>0){ ?>
<ul>
<?php
	foreach ($this->dirList as $dir){
		$fulldir = urlencode($this->currentDir.$dir);
		echo '<li><a href="javascript:loadDirectory(\''.$fulldir.'\')">'.$dir.'</a></li>';
	}
?>
</ul>
<?php 
}else{
	echo "<p>No directories in ".$this->displayDir.".</p>";
}
?>
</div>
<div id="files">
<p>
	<strong>Legal file extensions for viewing:</strong><?php echo $this->fileTypes; ?></p>
<?php if (count($this->filesList)>0){ ?>
<ul>
<?php
	jimport('joomla.filesystem.file');
	$ext = $this->FileImages;
	foreach ($this->filesList as $file){
		$fileExt = strtolower(JFile::getExt($file));
		if (isset($ext[$fileExt])){
			$src = $ext[$fileExt];
		}else{
			$src = $this->DefaultFileImage;
		}
		$image = '<img src="'.$src.'" alt="filetype image" />';
		$imagesize = format_bytes(@filesize($this->serverdir.$file));
		echo '<li><a href="javascript:setFile(\''.$file.'\',\''.$imagesize.'\');insertHTMLLink()">'.$image.$file.'</a></li>';
	}
?>
</ul>
<?php 
}else{
	echo "No matching files in ".$this->displayDir.".";
}
?>
</div>
<br style="clear:both" />