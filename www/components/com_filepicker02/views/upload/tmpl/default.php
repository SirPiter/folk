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
if ($this->msg!=''){
	echo '<script type="text/javascript" language="Javascript">alert(\''.$this->msg.'\')</script>';
}
?>
<form enctype="multipart/form-data" name="upload" action="index.php?option=com_filepicker&amp;view=upload&amp;tmpl=component" id="uploadform" method="POST">
<p><strong>Legal file extensions for uploading:</strong><?php echo $this->fileExtensions;?></p>
<p>Max. file upload size <strong><?php echo $max = ini_get('upload_max_filesize');?> Bytes</strong></p>
<p><input type="file" name="uploadfile" /></p>
<p><label for="overwriteId">Overrite existing files ? </label><input type="checkbox" name="overwrite" value="yes" id="overwriteId"/>
</p>
<p>
	<input name="uploaded" type="submit" value="upload" />
</p>
</form>