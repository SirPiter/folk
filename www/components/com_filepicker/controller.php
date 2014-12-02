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
jimport('joomla.application.component.controller');

//define('FILEPICKER_DEMO', true);
//define('FILEPICKER_NOINSERT', true);

class FilepickerController extends JController{

	function display(){
		parent::display();
	}
	
	function backendDisplay(){
		
		$site = JURI::base();
		$site = substr($site,0,-14);
		define('FILEPICKER_HTTP_ROOT',$site);
		define('FILEPICKER_BACKENDVIEW',true);
		
		//global $mainframe;
		
		$vName = JRequest::getVar('view', 'filepicker');
		$mName = '';
		switch ($vName)
		{
			case 'upload':
				$vLayout = JRequest::getCmd( 'layout', 'default' );
				$vName = 'upload';
				break;
			
			case 'files':
				$vLayout = JRequest::getCmd( 'layout', 'default' );
				$vName = 'files';
				break;		

			case 'filepicker':
			default:
				$vLayout = JRequest::getCmd( 'layout', 'default' );
				$vName = 'filepicker';
				break;
		}

		$document = &JFactory::getDocument();
		$vType		= $document->getType();

		// Get/Create the view
		$view = &$this->getView( $vName, $vType);
		$view->addTemplatePath(JPATH_COMPONENT_SITE.DS.'views'.DS.strtolower($vName).DS.'tmpl');

		// Get/Create the model
		if ($mName!=''){
			if ($model = &$this->getModel($mName)) {
				// Push the model into the view (as default)
				$view->setModel($model, true);
			}
		}

		// Set the layout
		$view->setLayout($vLayout);

		// Display the view
		$view->display();
	}
}
?>