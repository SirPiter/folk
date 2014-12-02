<?php

/**
 * @version		1.0.0
 * @package		konsa_expeditions
 * @copyright	2010 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class TableTown extends JTable
{

	var $id = null;
	var $town_name = null;
	var $coordinata = null;
	var $oldname = null;
	var $rename_year = null;
	var $type = null;
	var $region = null;
	var $subname = null;
	var $comment = null;

	function TableTown(& $db) {
		parent::__construct('#__konsa_exp_towns', 'id', $db);
	}
	
	function check(){
/*		if($this->format_image_file["name"] != ""){
			$success_image=false;
			$success_image = $this->guardarImatge($this->town_image_file);
			if($success_image) $this->icon = $success_image;
		}
		
		//if($this->display_group == $this->id ) $this->display_group = 0;
	*/
		return true;
	}
	
/*	function guardarImatge($file){
		$filename = $file["name"];

	  	if ($file["error"] > 0){
		  return false;
		}
	  	else{
			if (file_exists("../images/towns/" . $filename)){
				  $filename = time()."_".$filename;
				  move_uploaded_file($file["tmp_name"],"../images/towns/" . $filename);
				  return $filename;
			  }
			else{
				  move_uploaded_file($file["tmp_name"],"../images/towns/" . $filename);
				  return $filename;
			}
		}

	}  */
	
}
