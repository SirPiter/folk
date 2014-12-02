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
defined('_JEXEC') or die ('Restricted access');

include (JPATH_COMPONENT_SITE.DS.'assets'.DS.'includes'.DS.'version.php');

JHTML::_('behavior.mootools');

$js = '
  window.addEvent(\'load\', function() {
  	loadDirectory(\'\');
  	display("urlDisplay", false);
  });

 // window.addEvent(\'domready\', function(){
 // });

';

$document = & JFactory::getDocument();
$document->addScriptDeclaration($js);
?>
<script type="text/javascript" language="JavaScript">

		//File Images
		var editorName = '<?php $eName	= JRequest::getVar('e_name');
		$eName	= preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', $eName );
		echo $eName;
		?>';
		
		var defaultFileImage = "<?php echo $this->DefaultFileImage; ?>";
		var totalFileImageTypes = <?php echo count($this->FileImageTypes); ?>;
		var FileImageTypes = new Array;
		<?php
			for ($i=0;$i<count($this->FileImageTypes);$i++){					
				echo "FileImageTypes[$i]='".$this->FileImageTypes[$i]."';\n"; 
			}
		?>
		
		var FileImages = new Array;
		<?php
			foreach ($this->FileImages as $key => $value){
				echo "FileImages['$key']='$value';\n";
			}
		?>

		//Ajax load directory
		
		var loadDirectory = function(chdir) {
			cd=chdir;startLoad();
			var ajax1 = new Request.HTML({url:'index.php?option=com_filepicker&view=files&format=raw&chdir='+chdir, {method: 'post',postBody: '', data: {'no':'no'}, update:'fileManager',onFailure:function(){stopLoad();alert('Error by loading directory!')}, onComplete:function(){stopLoad()}}});
			
//			new Ajax( 'index.php?option=com_filepicker&view=files&format=raw&chdir='+chdir, {method: 'post',postBody: '', data: {'no':'no'}, update:'fileManager',onFailure:function(){stopLoad();alert('Error by loading directory!')}, onComplete:function(){stopLoad()}}).request();
//		}      
	var loadDirectory = function(chdir) {cd=chdir;startLoad();new Ajax( 'index.php?option=com_filepicker&view=files&format=raw&chdir='+chdir, {method: 'post',postBody: '', data: {'no':'no'}, update:'fileManager',onFailure:function(){stopLoad();alert('Error by loading directory!')}, onComplete:function(){stopLoad()}}).request();}

		//current directory
        
		var cd='';

		var file='';
		var URLSetting = 3;

    	var urlbase = '<?php echo FILEPICKER_HTTP_ROOT;?>';
    	var urlroot = '<?php echo $this->rooturl;?>'; 

		var fileSelected = false;
    	
    	var EncodingSetting = 1;

		function refreshDirectory(){
			loadDirectory(cd);
		}
		
        function startLoad(){
        }
        function stopLoad(){	
        }
		
		//display functions
        
        function display(id,d){
        	var str = 'none'
        	if (d==true){
        		str = '';
        	}
        	document.getElementById(id).style.display = str;
        }

		var currentdir='';
		var url='';
		
        function changeURLSettings(URLsetting,EncodingSettings){
    		URLSetting = URLsetting;
    		currentdir = document.getElementById('currentdir').innerHTML;
    		switch (URLSetting){
    			case 1:
    				url = urlbase+urlroot+currentdir+file;	
    			break;
    			case 2:
    			case 3:
    				url = urlroot+currentdir+file;
    			break;
    		}
    		EncodingSetting = EncodingSettings;
			if (EncodingSetting==2){
	        	document.getElementById('URL1').innerHTML = url;
			}else{
				if (URLSetting==3){
        			document.getElementById('URL1').innerHTML = escape(urlroot+currentdir+file);
	    		}else{
		    		var add = escape(urlroot+currentdir+file)
        			document.getElementById('URL1').innerHTML = urlbase+add;
	    		}
			}
    	}
    	 
    	function updateURLString(object){
    		file = '';
    		fileSelected = false;
    		url = object.value;
    		changeURLSettings(URLSetting, EncodingSetting);
    	}

		var globFilesizestr;
    	
        //display/hide insert buttons
        
        function setFile(selectedFile,filesizestr){
    		fileSelected = true;
    		file = selectedFile;
    		changeURLSettings(URLSetting, EncodingSetting);
			globFilesizestr = filesizestr; 
    		//hideDisplayInsertButtons();
    	}
                
        function insertHTMLLink()
        {
        	if (url==''){
        		alert('<?php echo $this->enterURLText;?>');
        		return;
        	}
			var dummylink = new Element('a', {href: "index.php?&option=com_filepicker&view=insertsettings&tmpl=component" ,rel: "{handler: 'iframe', size: {x: 600, y: 350}}"});
			SqueezeBox.fromElement(dummylink);
			return;		
        }

		function getExt(strfile){
			var extLength = 0;
			for (var i=strfile.length;i>=0;i--){
				extLength++;
				if (strfile.substring(i,i+1)=='.'){
					return strfile.substring(i+1,i+extLength-1);
				}
			}
			return '';
		}
    	
        function getImage(strfile){
			var ext = '';
			ext = getExt(strfile);
			for (var i=0;i<totalFileImageTypes;i++){
				if (FileImageTypes[i]==ext){
					return FileImages[ext];
				}
			}
			return defaultFileImage;
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
		
		
		
	//////////////////////////////////////////////////	
	window.addEvent('domready', function(){

  $('makeRequest').addEvent('click', function(event){
    event.stop();

    new Request.HTML({

      url: '/echo/html/',

      onRequest: function(){
        $('result').set('text', 'loading...');
      },

      onComplete: function(response){
        $('result').empty().adopt(response);
      },

      data: {
        // This is some content that the server will return
        // we pass this only for our demo runner and jsfiddle
        html: '<h3>The Request Was Successful</h3>' +
          '<p>Here is some <em>HTML content</em>.  It\'s pretty neat, isn\'t it?</p>' +
          '<p>It does not have to be a complete page, since the <head> section is already present in the parent page.</p>' +
          '<p>If we had things inside this HTML that needed some MooTools love (the sort of things that go inside the domready event), we would have to call our scripts\' attention to this code manually.</p>'
      }

    }).send();

  });

});
		
</script>

<div id="filepickerFooter">FilePicker version <?php echo FILEPICKER_VERSION?>, created by <a href="http://www.webconstruction.ch/" target="_blank" title="opens webconstruction site in new window">www.webconstruction.ch</a></div>
<?php
jimport('joomla.html.pane');
$pane = & JPane::getInstance('Tabs');
echo $pane->startPane('panels');
if ($this->showFilemanager){
	$panel1Name = 'File Browser';
}else{
	$panel1Name = 'Url';
}
echo $pane->startPanel($panel1Name, 'panel1');
?>
<div id="urlDisplay" style="display:none">
	<label for="URL1">
	URL
	</label><br />
	<textarea id="URL1" readonly="readonly" cols="85" rows="1"></textarea>
</div>
<div id="Insert">
</div>
<div id="fileManager">
</div>
<?php if ($this->showFileuploader){
?>
<div id="uploader">
<?php
	jimport('joomla.html.html');
	$uploadModalParams = array('size'=>array('x'=>300,'y'=>50));
	JHTML::_('behavior.modal','a.uploadModal',$uploadModalParams);
	echo '<div style="float:left"><a class="uploadModal" title="upload SWF file to current directory" href="index.php?option=com_filepicker&view=upload&tmpl=component" rel="{handler: \'iframe\', size:{x:500, y:300}, onClose:function(){refreshDirectory();}}">Upload: <img src="'.FILEPICKER_HTTP_ROOT.'/components/com_filepicker/assets/images/upload.png" alt="Upload SWF-file to current directory" title="Upload SWF-file to current directory"/></a></div>';
?>
</div>	

<?php
	}
?>
<?php if ($this->showCreatDirectory){
?>
<div id="createdir">
<?php
	jimport('joomla.html.html');
	$uploadModalParams = array('size'=>array('x'=>300,'y'=>50));
	JHTML::_('behavior.modal','a.createDirModal',$uploadModalParams);
	echo '<div style="float:left"><a class="createDirModal" title="create a new directory" href="index.php?option=com_filepicker&view=createdir&tmpl=component" rel="{handler: \'iframe\', size:{x:500, y:300}, onClose:function(){refreshDirectory();}}">Create directory: <img src="'.FILEPICKER_HTTP_ROOT.'/components/com_filepicker/assets/images/createdir.png" alt="Create directory in current directory" title="Create directory in current directory"/></a></div>';
?>
</div>	
<div style="clear:both"></div>
<?php
	}
?>
<?php
echo $pane->endPanel();
echo $pane->startPanel('Проба', 'panel2');
?>

<p>
<a id="makeRequest" href="#">Get HTML</a>
</p>

<select name="drop-down" id="drop-down">
        <option value="1">Item 1</option>
        <option value="2">Item 2</option>
        <option value="3">Item 3</option>
</select>

<?php
$options = array();
$options[] = JHTML::_( 'select.option', '1', 'Item 1' );
$options[] = JHTML::_( 'select.option', '2', 'Item 2' );
$options[] = JHTML::_( 'select.option', '3', 'Item 3' );
echo JHTML::_( 'select.genericlist', $options, 'drop-down' );
?>

<div id="result">Waiting for the request to happen.</div>

<div id="ajax-container"></div>
<?php
echo $pane->endPanel();
echo $pane->endPane();