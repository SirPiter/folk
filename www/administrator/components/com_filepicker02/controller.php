<?php
/**
 * @version 1.1.0
 * @package Joomla
 * @subpackage FilePicker
 * @author Milton Pfenninger <info@webconstruction.ch>
 * @copyright Copyright (C) 2009 - 2010 Milton Pfenninger. All rights reserved.
 * @license GNU/GPL
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.controller');
jimport( 'joomla.environment.request' );

class AdminFilepickerController extends JController
{
	function display(){
		parent::display();
	}
	
	function _save(){
	   $component = 'com_filepicker';
//	   $table =& JTable::getInstance('component');
//	   if (!$table->loadByOption( $component ))

	   $table = JTable::getInstance('Extension');
	   if (!$table->load($table->find(array('name' => 'com_filepicker'))))
	   {
	      JError::raiseWarning( 500, 'Not a valid component' );
	      return false;
	   }
	   $post = JRequest::get( 'post' );
//print_r($post); 
	   $post['option'] = $component;
	   $table->bind( $post );
	 //  $table->params=$post;
	   
	   // pre-save checks
	  if (!$table->check()) {
	      JError::raiseWarning( 500, $table->getError() );
		  //$this->setError($table->getError());
		  //print_r($this->Error);
	      return false;
	   }
	   
	   // save the changes
	   if (!$table->store()) {
	      JError::raiseWarning( 500, $table->getError() );
	      return false;
	   }
	   return true;
	}
	
	function save(){
	   $msg = JText::_('Configurations successfully saved.');
	   if (!$this->_save()){
	      JError::raiseWarning(2,JText::_('Failed saving configurations.'));
	      $msg = null;
	   }
	   $this->setRedirect('index.php?option=com_filepicker&view=adminfilepicker',$msg);
	   $this->redirect();
	}
}