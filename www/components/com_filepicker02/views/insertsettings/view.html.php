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
//import the JView class
jimport('joomla.application.component.view');

class FilepickerViewinsertsettings extends JView
{

	function display($tmp = null)
	{	
		$document =& JFactory::getDocument();
		$document->addStyleSheet( FILEPICKER_HTTP_ROOT . 'components/com_filepicker/assets/css/insertsettings.css', 'text/css', null, array() );
		
		@$params = &JComponentHelper::getParams( 'com_filepicker' );
		$this->assignRef('params',$params);
		
		//get text templates
		
		$textDefaultSelect = $params->get('textDefaultSelect','{file},Click to download {img} {file},Download {file},Click to download from {url},Click to download {path}, Click to download from {urlnohttp}');
		
		$textDefaultArray = FilepickerParamHelper::getParamArray($textDefaultSelect,array(),array(',',"\n"));
		$textSelect = '<select onchange="copyselect(\'selectlinktext\',\'linktext\');doPreview();" id="selectlinktext">';
		$textSelect .= '<option value="">-- NOT SET --</option>';
		$default = addslashes($this->params->get('defaultLinkText','{file}'));
		$textSelect .= '<option value="'.$default.'">-- DEFAULT --</option>';
		for ($i=0;$i<count($textDefaultArray);$i++){
			if (trim($textDefaultArray[$i])!=""){
				$textSelect .= '<option value="'.$textDefaultArray[$i].'">'.$textDefaultArray[$i].'</option>';
			}
		}
		$textSelect .= '</select>';
		$this->assignRef('htmlTextSelect',$textSelect);

		//get title templates
		
		$titleDefaultSelect = $params->get('titleDefaultSelect','{linktext},{file},Click to download {linktext},Download {linktext},Click to download {file},Download {file},Click to download from {url},Click to download {path}, Click to download from {urlnohttp}');
		
		$titleDefaultArray = FilepickerParamHelper::getParamArray($titleDefaultSelect,array(),array(',',"\n"));
		$titleSelect = '<select onchange="copyselect(\'selecttitle\',\'title\');doPreview();" id="selecttitle">';
		$titleSelect .= '<option value="">-- NOT SET --</option>';
		$default = addslashes($this->params->get('defaultTitle',''));
		$titleSelect .= '<option value="'.$default.'">-- DEFAULT --</option>';
		for ($i=0;$i<count($titleDefaultArray);$i++){
			if (trim($titleDefaultArray[$i])!=""){
				$titleSelect .= '<option value="'.$titleDefaultArray[$i].'">'.$titleDefaultArray[$i].'</option>';
			}
		}
		$titleSelect .= '</select>';
		$this->assignRef('htmlTitleSelect',$titleSelect);
		jimport('joomla.html.html');
		JHTML::_('behavior.tooltip');
		
		parent::display($tmp);		
	}
}