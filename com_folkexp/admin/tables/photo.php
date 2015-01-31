<?php

/**
 * @version		2.5.4
 * @package		konsaexp
 * @copyright	2014 SP
 * @license		GPLv2
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


class TablePhoto extends JTable
{

	var $id = null;
	var $title = null;        // Заголовок
	var $short_description = null;    // краткое описание
	var $description = null;    // описание
	var $parents_id = null;		// ссылка на главный документ
	var $image = null;		// картинка к 
	var $date = null;		// дата составления 
	var $place_id = null;	// место составления 
	var $expedition_id;		// ссылка на экспедицию
	var $add_date = null;		// дата добавления в базу
	var $path = null;		// расположение 
	var $comment = null;	// комментарий
	var $autor_id = null;		// ссылка на автора
	var $collector_id = null;	// ссылка на собирателя
	
		
	
	function TablePhoto(& $db) {
		parent::__construct('#__konsa_exp_photos', 'id', $db);
	}

	function check(){
		return true;
	}

	function prepare_photo(){

		$art = $this->title;
//		$inicial = $this->letter;
		$class_name = $this->class_name;
		//$web_lyrics = $this->web_lyrics;
//		$keywords = $this->keywords;

		if(!$class_name){
			if(strncasecmp($art,"The ",4)==0) $class_art = substr($art,4);
			else $class_art = $art;
		}
		else{
			$class_art = $class_name;
		}

	/*	$string_key = " ".$art." ".$keywords." ";

		if($this->id == 0){
			$string_key = $this->get_keywords($string_key);
		}
		else{
			$string_key = $this->get_keywords($keywords);
		}
    */
		if(!$inicial){
			$this->letter = substr($class_art,0,1);
			$exep = array("1","2","3","4","5","6","7","8","9","0","!","?","ї","Ў","'","$","(",")");
			if(in_array($this->letter,$exep))	$this->letter = "1";
		}
		$this->letter = strtoupper($this->letter);
		$this->class_name = $class_art;
	//	$this->keywords = $string_key;

	}

	function get_keywords($keywords){

		$return = JFilterOutput::stringURLSafe($keywords);
		$return = str_replace("-"," ",$return);
		$return = $this->erase_multiple_whitespaces(" ".$return." ");

		return $return;
	}

	function erase_multiple_whitespaces($cadena){
		$cadena2 = str_replace("  "," ",$cadena,$times);
		if($times!=0) $cadena2 = $this->erase_multiple_whitespaces($cadena2);
		return $cadena2;
	}

	function guardarImatge($file){
		$filename = $file["name"];

	  	if ($file["error"] > 0){
		  return false;
		}
	  	else{
			if (file_exists("../images/documents/" . $filename)){
				  $filename = time()."_".$filename;
				  move_uploaded_file($file["tmp_name"],"../images/documents/" . $filename);
				  return $filename;
			  }
			else{
				  move_uploaded_file($file["tmp_name"],"../images/documents/" . $filename);
				  return $filename;
			}
		}

	}

}