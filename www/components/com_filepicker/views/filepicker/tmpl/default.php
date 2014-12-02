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
defined('_JEXEC') or die ('Restricted access');

define('FILEPICKER_VERSION','0.1.0 Beta');

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
		
		var loadDirectory = function(chdir) {cd=chdir;startLoad();
		//alert("load! 1 : "+chdir);
//		new Ajax( 'index.php?option=com_filepicker&view=files&format=raw&chdir='+chdir, {method: 'post',postBody: '', data: {'no':'no'}, update:'fileManager',onFailure:function(){stopLoad();alert('Error by loading directory!')}, onComplete:function(){stopLoad()}}).request();}      
		var myHTMLRequest = new Request.HTML({url: 'index.php?option=com_filepicker&view=files&format=raw&chdir='+chdir,
		data: {'no':'no'},
		update:'fileManager',
		onFailure:function(){stopLoad();alert('Error by loading directory!')},
		onComplete:function(){stopLoad()}
		}).post();
	//		alert("load! 2 : "+chdir);

		}

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

        //display/hide insert buttons
        
        function hideDisplayInsertButtons(){
			var innerHTMLString='<p><?php echo JText::_( "Please select directory and file" ); ?>.</p>'
			if (trim(file)!=""){
				display("urlDisplay", true);
//				innerHTMLString = '<p><input type="button" onclick="insertHTMLLink();" value="Insert HTML Link" />&nbsp;&nbsp;&nbsp;<input type="button" onclick="insertLink();" value="Insert Link as Text" /></p>';				
				innerHTMLString = '<p>&nbsp;&nbsp;<input type="button" onclick="insertLink();" value=<?php echo JText::_( "Insert Link as Text"); ?> /></p>';				

}else{
				display("urlDisplay", false);
			}
			document.getElementById('Insert').innerHTML = innerHTMLString;
        }

        function setFile(selectedFile){
    		fileSelected = true;
    		file = selectedFile;
    		changeURLSettings(URLSetting, EncodingSetting);
    		hideDisplayInsertButtons();
    	}
                
        	/**
        	 * Files handling -- start --
        	 * 
        	 */
        	        
        function insertHTMLLink()
        {

        	if (url==''){
        		alert('<?php echo $this->enterURLText;?>');
        		return;
        	}
			<?php $eName	= JRequest::getVar('e_name');
			$eName	= preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', $eName );?>
			var textSetting = prompt("Text of the link? Press Cancel for URL of Link",file);
			if (!textSetting){
				textSetting = url;
			}
			var title = file;
			if (file!=textSetting && textSetting!=url){
				title = textSetting;
			}
			var titleSetting = prompt("Title of the link? Press Cancel for no title",title);
			if (!titleSetting){
				titleSetting = '';
			}else{
				titleSetting = ' title="'+titleSetting+'"';
			}
			var targetSet = prompt("Target of Link? 0 for no target or press Cancel, 1 for _self, 2 for _blank, 3 for _top or enter target","0");
			if (!targetSet){
				targetSet = "0";
			}
			switch (trim(targetSet)){
			case "0":
				targetSetting = '';
			break;
			case "1":
				targetSetting = ' target="_self"';
			break;
			case "2":
				targetSetting = '';
				targetSetting = ' target="_blank"';
			break;
			case "3":
				targetSetting = ' target="_top"';
			break;
			default:
				targetSetting = ' target="'+targetSet+'"';
			break;
			}		
			if (EncodingSetting==2){
				url2 = url;
			}else{
				if (URLSetting==3){
					url2 = escape(urlroot+currentdir+file);
	    		}else{
		    		var add = escape(urlroot+currentdir+file)
        			url2 = urlbase+add;
	    		}
			}			
			var imgsrcAdd = getImage(file);
			var imgHTML = '';
			if (document.getElementById('addfileimage').checked == true){
				var ext = getExt(file);
				imgHTML = '<img src="' + imgsrcAdd + '" alt="file icon '+ext+'" />&nbsp;';
			}
			var urllink = '<a href="'+url2+'"'+targetSetting+titleSetting+'>'+imgHTML+textSetting+'</a>';
			var q = confirm("Are you sure you want to insert the following link? "+urllink);
			if (q==false)return;
			<?php 
			if (defined('FILEPICKER_NOINSERT')){
				echo "return;";	
			}
			?>
			window.parent.jInsertText(urllink, '<?php echo $eName; ?>');
        	//window.parent.document.getElementById('sbox-window').close();
			window.parent.SqueezeBox.close();
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
       
        function insertLink()
        {
			if (url==''){
        		alert('<?php echo $this->enterURLText;?>');
        		return;
			}
			<?php 
					if (defined('FILEPICKER_NOINSERT')){
						echo "return;";	
					}
			?>
        	
			jInsertText(url, '<?php echo preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', JRequest::getVar('e_name') ); ?>');
			
			
			
			//jInsertAudio(url, '<?php echo preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', JRequest::getVar('pleer') ); ?>');
			
			
			//window.parent.document.getElementById('sbox-window').close();
			window.parent.SqueezeBox.close();
        	return;
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
		
		function jInsertText( text, editor ) {
			var el = window.parent.document.getElementById(editor);
			el.value = text;
			return;
		}

		function jInsertAudio( text, pleer ) {
			//alert(pleer);
			//var el = window.parent.document.getElementById(pleer);
//			el.value = text;
			//window.opener.AudioPlayer.embed(pleer, {soundFile: "http://music.sirpiter.ru/"+text});
			
			return;
		}

					

		
</script>
<?php
jimport('joomla.html.pane');
$pane = & JPane::getInstance('Tabs');
echo $pane->startPane('panels');
if ($this->showFilemanager){
	$panel1Name =  JText::_('File Browser');
}else{
	$panel1Name = 'Url';
}
echo $pane->startPanel($panel1Name, 'panel1');
?>
<div id="urlDisplay">
<p>
	<label for="URL1">
	URL
	</label><br />
	<textarea id="URL1" readonly="readonly" cols="65" rows="2"></textarea>
</p>
</div>
<div id="Insert">
<p> <?php echo JText::_('Please select directory and file'); ?>.</p>
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
	echo '<a class="uploadModal" title="upload SWF file to current directory" href="index.php?option=com_filepicker&view=upload&tmpl=component" rel="{handler: \'iframe\', size:{x:400, y:150}, onClose:function(){refreshDirectory();}}">'.JText::_("Upload").': <img src="'.FILEPICKER_HTTP_ROOT.'/components/com_filepicker/assets/images/upload.png" alt="Upload SWF-file to current directory" title="Upload SWF-file to current directory"/></a>';
?>
</div>	

<?php
	}
?>
<?php
echo $pane->endPanel();
echo $pane->startPanel(JText::_('Settings'), 'panel2');
?>
    <fieldset>
        <p>
			<label for="URLRelative">
                <?php echo JText::_('Relative URL'); ?>
            </label>
            <input onclick="changeURLSettings(3,EncodingSetting);" checked="checked" type="radio" id="URLRelative" name="urlSettings" value="3"/>| 
            <label for="URLAbsolute">
                <?php echo JText::_('Absolute URL'); ?>
            </label>
			<input onclick="changeURLSettings(1,EncodingSetting);" type="radio" id="URLAbsolute" name="urlSettings" value="1"/>
        </p>
        <p>
			<label for="URLEncoding">
                Escape URL (recommended)
            </label>
            <input onclick="changeURLSettings(URLSetting,1);" checked="checked" type="radio" id="URLEncoding" name="nameURLEncoding" value="1"/>| 
            
            <label for="URLNotEncoding">
                Don't escape URL
            </label>
			<input onclick="changeURLSettings(URLSetting,2)" type="radio" id="URLNotEncoding" name="nameURLEncoding" value="2"/>
        </p>
        <p>
        	<label for="addfileimage">
        		Add file-type image to HTML-Link or Link-Text
        	</label>
        	<input type="checkbox" checked="checked" id="addfileimage" />
        </p>
        <?php /*
        to be added in next version 
        <p>
        	<input type="button" onclick="saveSettings()" value="Save Setting" />
        </p>*/
        ?>
    </fieldset>
<?php
echo $pane->endPanel();
echo $pane->endPane();
?>
<div id="filepickerFooter">FilePicker version <?php echo FILEPICKER_VERSION?>, created by <a href="http://www.webconstruction.ch/" target="_blank" title="opens webconstruction site in new window">www.webconstruction.ch</a></div>