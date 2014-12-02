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
defined('_JEXEC') or die(); 
?>
<script language="javascript" type="text/javascript">
function submitbutton(pressbutton) {
   submitform(pressbutton);
}

function renderImages(id){
	var obj,array,html,array2;
	obj = document.getElementById(id);
	document.getElementById('previewIconDisplay').innerHTML = '';
	array2 = document.getElementById('paramsDefaultFileImage').value;
	renderImage(array2, true);
	array = obj.value;
	array = array.split(',');
	for (var i=0;i<array.length;i++){
		renderImage(array[i], false);
	}
}

function renderImage(array, isdefault){
	var html, type, array2
	array2 = array.split('=');
	if (isdefault==true||(array2[1]!=undefined&&array2[0]!=undefined)){
		if (isdefault){
			array2[0]='default';
			array2[1]=array;
		}
		type = trim(array2[0]);
		html = array2[1];
		html = trim(array2[1]);
		html = unescape(html);
		html = html.replace('{ComponentImagesPath}','components/com_filepicker/assets/images/filetypes/');
		html = '<tr><td>'+type+'</td><td><img src="../'+html+'" alt="'+type+'" /></td></tr>';
		document.getElementById('previewIconDisplay').innerHTML += html;
	}
}

function trim(str, chars) {
	return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}




</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<?php
jimport('joomla.html.pane');
$pane =& JPane::getInstance( 'tabs' );
$sliders =& JPane::getInstance( 'sliders' );
echo $pane->startPane( 'content-pane' );
echo $pane->startPanel( JText::_( 'User Settings' ), 'userSettings' );
echo $sliders->startPane( 'content-pane' );
echo $sliders->startPanel( JText::_( 'Guests' ), 'guestSettings' );
echo $this->params->render( 'params','guests' );
echo $sliders->endPanel();
echo $sliders->startPanel( JText::_( 'Registered' ), 'registeredSettings' );
echo $this->params->render( 'params','registered' );
echo $sliders->endPanel();
echo $sliders->startPanel( JText::_( 'Editors' ), 'editorsSettings' );
echo $this->params->render( 'params','editors' );
echo $sliders->endPanel();
echo $sliders->startPanel( JText::_( 'Authors' ), 'authorsSettings' );
echo $this->params->render( 'params','authors' );
echo $sliders->endPanel();
echo $sliders->startPanel( JText::_( 'Publishers' ), 'publishersSettings' );
echo $this->params->render( 'params','publishers' );
echo $sliders->endPanel();
echo $sliders->startPanel( JText::_( 'Managers' ), 'managersSettings' );
echo $this->params->render( 'params','managers' );
echo $sliders->endPanel();
echo $sliders->startPanel( JText::_( 'Administrators' ), 'administratorsSettings' );
echo $this->params->render( 'params','administrators' );
echo $sliders->endPanel();
echo $sliders->startPanel( JText::_( 'Super Administrators' ), 'superadministratorsSettings' );
echo $this->params->render( 'params','superadministrators' );
echo $sliders->endPanel();
echo $sliders->endPane();
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'General Settings' ), 'templatesAndDefaults' );
echo $this->params->render( 'params','settings' );
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'Icons' ), 'previewIcons' );
?>
<table>
	<tr><td style="vertical-align:top">
<?php echo $this->params->render( 'params','icons' );
?>
	</td>
	<td style="vertical-align:top">
	<input type="button" value="<?php echo JText::_('Preview/refresh Icons');?>" onclick="renderImages('paramsFileImages');" />
	<div style="height:300px;width:100px;overflow:auto">
	<table id="previewIconDisplay">
	</table>
	</div>
	</td>
	</tr>
</table>
<?php
echo $pane->endPanel();
echo $pane->startPanel( JText::_( 'Templates' ), 'previewTemplates' );
echo $this->params->render( 'params','templates' );
?>

<?php
echo $pane->endPanel();
echo $pane->endPane();
?>
<input type="hidden" name="option" value="com_filepicker" />
<input type="hidden" name="task" value="save" />
</form>