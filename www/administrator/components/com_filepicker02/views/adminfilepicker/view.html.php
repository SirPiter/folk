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

jimport( 'joomla.application.component.view' );
jimport( 'joomla.database.table.component' );

class adminFilepickerViewadminFilepicker extends JView
{
  function display($tpl = null)
  {
	$doc =& JFactory::getDocument();
	$style = " .icon-48-filepickerlogo {background-image:url(components/com_filepicker/assets/images/filepickerlogo.png); no-repeat; }";
	$doc->addStyleDeclaration( $style );
	JToolBarHelper::title('File Picker [<small>Configurations</small>]', 'filepickerlogo.png');
	JToolBarHelper::save(); 
    //$table =& JTable::getInstance('Extensions');
$table = JTable::getInstance('Extension');
//$table->load($table->find(array('name' => 'com_filepicker')));

//print_r($table); 
//print_r($doc); 
//die;
 //  if (!$table->loadByOption( 'com_filepicker' ))
 //   {
 //      JError::raiseWarning( 500, 'Not a valid component' );
 //      return false;
 //   }


    if (!$table->load($table->find(array('name' => 'com_filepicker'))))
    {
       JError::raiseWarning( 500, 'Not a valid component' );
       return false;
    }
    $paramsdata = $table->params;
    $paramsdefs = JPATH_COMPONENT.DS.'config.xml'; 
    $params = new JParameter( $paramsdata, $paramsdefs );
    $this->assignRef('params', $params);

    jimport('joomla.html.html');
    JHTML::_('behavior.mootools');
    JHTML::_('behavior.tooltip'); //Tooltips
	
    parent::display($tpl);
  }  
}
