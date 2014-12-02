<?php
/**
 * @version 0.2.0 Beta
 * @package Joomla
 * @subpackage FilePicker
 * @author Milton Pfenninger <info@webconstruction.ch>
 * @copyright Copyright (C) 2009-2010 Milton Pfenninger. All rights reserved.
 * @license GNU/GPL
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die ('Restricted access');
jimport('joomla.html.html');
?>
<script type="text/javascript" language="JavaScript">
	var linkText = "";
	var target = "";
	var title = "";
	var urlsetting = false;
	var encodeurl = true;
	var onlytext = false;
	function copyselect(objid,elid){
		document.getElementById(elid).value = document.getElementById(objid).value;
	}
	
	function getSettings(){
		document.getElementById('linktext').value = '<?php echo addslashes($this->params->get('defaultLinkText','{file}'));?>';
		document.getElementById('title').value = '<?php echo addslashes($this->params->get('defaultTitle',''));?>';
		document.getElementById('target').value = '<?php echo addslashes($this->params->get('defaultTarget',''));?>';
		document.getElementById('addfileimage').value = '<?php $value = $this->params->get('defaultAddImage','Left');
			echo $value;
		?>';
		document.getElementById('urlsetting').checked = <?php $value = intval($this->params->get('defaultAbsoluteUrl',0));
		if ($value == 1){
			echo "true";	
		}else{
			echo "false";	
		}
		?>;
		document.getElementById('encodeurl').checked = <?php $value = intval($this->params->get('defaultEscapeUrl',1));
		if ($value == 1){
			echo "true";	
		}else{
			echo "false";	
		}
		?>;
		document.getElementById('astext').checked = <?php $value = intval($this->params->get('defaultOnlyText',0));
		if ($value == 1){
			echo "true";	
		}else{
			echo "false";	
		}
		?>;
		doPreview();
	}
	function doPreview(){
		linkText = document.getElementById('linktext').value;
		target = document.getElementById('target').value;
		title = document.getElementById('title').value;
		urlsetting = (document.getElementById('urlsetting').checked == true);
		encodeurl = (document.getElementById('encodeurl').checked == true);
		onlytext = (document.getElementById('astext').checked == true);
		var link;
		link = getlink(true);
		document.getElementById('previewhtml').innerHTML=link;
	}
	function getlink(preview){
		var phfullurl = parent.urlbase+parent.urlroot+parent.currentdir+parent.file;	
		var phurlnohttp = phfullurl.substring(7,phfullurl.length);
		var phpath = parent.urlroot+parent.currentdir+parent.file;
		var phdir = parent.urlroot+parent.currentdir;
		var imgpathPreview = '';
		if (preview){
			imgpathPreview = parent.urlbase;
		}
		if (!encodeurl){
			if (urlsetting||(preview && !onlytext)){
				url2 = parent.urlbase+parent.urlroot+parent.currentdir+parent.file
			}else{
				url2 = parent.urlroot+parent.currentdir+parent.file				
			}
		}else{
			if (urlsetting||(preview && !onlytext)){
	    		var add = encodeURI(parent.urlroot+parent.currentdir+parent.file)
    			url2 = parent.urlbase+add;
    		}else{
				url2 = encodeURI(parent.urlroot+parent.currentdir+parent.file);
    		}
		}	
		var imgsrcAdd = parent.getImage(parent.file);
		var imgHTML = '';
		var imgHTMLRight = '';
		var img = '';
		if (document.getElementById('addfileimage').value != 'No'){
			var ext = parent.getExt(parent.file);
			img = '<img src="' + imgpathPreview + imgsrcAdd + '" alt="file icon '+ext+'" />'
			if (document.getElementById('addfileimage').value == 'Right'){
				imgHTMLRight = '&nbsp;'+img;
			}else{
				imgHTML = img+'&nbsp;';
			}
			if (document.getElementById('addfileimage').value == 'Only in template'){
				imgHTML = '';
				imgHTMLRight = '';
			}
		}
		var targetSetting = '';
		var titleSetting = '';
		var textSetting=linkText;
		
		if (parent.trim(target)!=''){
			targetSetting = ' target="'+target+'"';
		}
		textSetting = textSetting.replace(/\{url\}/g,phfullurl);
		textSetting = textSetting.replace(/\{file\}/g,parent.file);
		textSetting = textSetting.replace(/\{urlnohttp\}/g,phurlnohttp);
		textSetting = textSetting.replace(/\{path\}/g,phpath);
		textSetting = textSetting.replace(/\{dir\}/g,phdir);
		textSetting = textSetting.replace(/\{size\}/g,parent.globFilesizestr);
		if (parent.trim(title)!=''){
			var titletmp = '';
			titletmp = title.replace(/\{url\}/g,phfullurl);
			titletmp = titletmp.replace(/\{file\}/g,parent.file);
			titletmp = titletmp.replace(/\{linktext\}/g,textSetting.replace(/\{img\}/g,''));
			titletmp = titletmp.replace(/\{urlnohttp\}/g,phurlnohttp);
			titletmp = titletmp.replace(/\{path\}/g,phpath);
			titletmp = titletmp.replace(/\{dir\}/g,phdir);
			titletmp = titletmp.replace(/\{size\}/g,parent.globFilesizestr);
			titleSetting=' title="'+titletmp+'"';
		}
		if (textSetting.search('{img}')!=-1){
			if (onlytext==false){
				imgHTML = '';
				imgHTMLRight = '';
			}
			textSetting = textSetting.replace(/\{img\}/g,img);
		}
		if (preview){
			targetSetting = ' target="_blank"';
		}
		var href = 'href="'+url2+'"';
		if (onlytext==true){
			return imgHTML+url2+imgHTMLRight;			
		}
		var urllink = '<a '+href+targetSetting+titleSetting+'>'+imgHTML+textSetting+imgHTMLRight+'</a>';
		if (preview!=true){
			<?php 
			if (defined('FILEPICKER_NOINSERT')){
				echo "return;";	
			}
			?>
			window.parent.parent.jInsertEditorText(urllink, parent.editorName);
			window.parent.parent.document.getElementById('sbox-window').close();
        	window.parent.document.getElementById('sbox-window').close();
        	return;
		}
		return urllink;
	}
	function cancelInsert(){
    	window.parent.document.getElementById('sbox-window').close();
	}
</script>
<body onload="getSettings()">
<div id="filepickerLinksettings">
<div id="buttons">
<h3 class="title">Insert Settings</h3>
<div class="button"><a href="javascript:cancelInsert()"><img src="<?php echo FILEPICKER_HTTP_ROOT.'/components/com_filepicker/assets/images/icon-32-cancel.png';?>" alt="Cancel"/><br />Cancel</a></div>
<div class="button"><a href="javascript:getlink()"><img src="<?php echo FILEPICKER_HTTP_ROOT.'/components/com_filepicker/assets/images/icon-32-new.png';?>" alt="Insert"/><br />Insert</a></div>
</div>
<table>
	<tr>
		<td>
			<?php echo JHTML::_('tooltip','Use {file}, {url}, {urlnohttp}, {path}, {dir},{img}, {size} as placeholders.','Link Text');?>
			<label for="linktext">Link text:</label>
		</td>
		<td>
			<input onchange="doPreview();" type="text" id="linktext" value=""/>
			<?php echo JHTML::_('tooltip','You can define templates in the Joomla Administration in the Components Menu under File Picker','Templates');?>
			<?php echo $this->htmlTextSelect;?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo JHTML::_('tooltip','Use {file}, {url}, {urlnohttp}, {path}, {dir},{img}, {size} as placeholders.','Title of link');?>
			<label for="title">Title of link:</label>
		</td>
		<td>
			<input onchange="doPreview();" type="text" id="title" value=""/>
			<?php echo JHTML::_('tooltip','You can define templates in the Joomla Administration in the Components Menu under File Picker','Templates');?>
			<?php echo $this->htmlTitleSelect;?>			
		</td>
	</tr>
	<tr>
		<td>
			<label for="target">Target:</label>
		</td>
		<td>
			<input onchange="doPreview();" type="text" id="target" value=""/>
			<select onchange="copyselect('selecttarget','target');doPreview();" id="selecttarget">
				<option value="">-- NOT SET --</option>
				<option value="<?php echo addslashes($this->params->get('defaultTarget',''));?>">-- DEFAULT --</option>
				<option value="_self">Open in this window / frame</option>
				<option value="_blank">Open in new window</option>
				<option value="_parent">Open in parent window / frame</option>
				<option value="_top">Open in top frame (replaces all frames)</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<label for="addfileimage">Add image:</label>
		</td>
		<td>
			<select onchange="doPreview();" id="addfileimage" />
				<option value="No">No</option>
				<option value="Left" selected="selected">Left</option>
				<option value="Right">Right</option>
				<option value="Only in template">Only in template</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<label for="urlsetting">Absolut URL:</label>
		</td>
		<td>
			<input onclick="doPreview();" type="checkbox" id="urlsetting" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="encodeurl">Escape URL<br />(recommended):</label>
		</td>
		<td>
			<input onclick="doPreview();" type="checkbox" checked="checked" id="encodeurl" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="astext">Link as Text</label>
		</td>
		<td>
			<input onclick="doPreview();" type="checkbox" id="astext" />
		</td>
	</tr>
</table>
<p><strong>Preview:</strong></p>
<div id="previewhtml">&nbsp;</div>
</div>
</body>