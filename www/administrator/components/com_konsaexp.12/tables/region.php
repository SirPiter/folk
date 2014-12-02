<?php

/**
 * @version		1.0.0
 * @package		konsa_expeditions
 * @copyright	2010 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class TableRegion extends JTable
{

	var $id = null;
	var $region_name = null;
	var $okrug = null;
	var $capital = null;
	var $region_code = null;
	var $comment = null;

	function TableRegion(& $db) {
		parent::__construct('#__konsa_exp_regions', 'id', $db);
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
