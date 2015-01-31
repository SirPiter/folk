<?php

/**
 * @version		1.5.0
 * @package		muscol
 * @copyright	2009 JoomlaMusicSolutions.com
 * @license		GPLv2
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


class TableArtist extends JTable
{

	var $id = null;
	var $artist_name = null;        // имя
	var $artist_lastname = null;    // фамилия
	var $artist_secondname = null;  // отчество
	var $artist_full_name = null;  // ФИО
	var $letter = null;       // буква для поиска
	var $comment = null;       // комментарий
	var $image = null;        // путь к картинке
	var $class_name = null;   // классификатор
	var $keywords = null;     // ключевые слова
	var $related = null;      // связи
	var $added = null;        // дата добавления
	var $birth_date = null;        // дата рождения
	var $death_date = null;        // дата смерти
	var $place_of_birth = null;        // место рождения
	var $place_of_death = null;        // место смерти
	var $place = null;        // место жизни
//	var $hits = null;
//	var $country = null;
	//var $web_lyrics = null;

	var $artist_image_file = null;

	function TableArtist(& $db) {
		parent::__construct('#__konsa_exp_artists', 'id', $db);
	}

	function check(){

		if($this->id == 0){
			$this->added =  date('Y-m-d H:i:s') ;
		}

		if($this->artist_image_file["name"] != ""){
			$success_image=false;
			$success_image = $this->guardarImatge($this->artist_image_file);
			if($success_image) $this->image = $success_image;
			//$this->artist_image_file = null;
		}

		if(is_array($this->related)) $this->related = implode(",",$this->related);
		$this->prepare_artist();

		return true;
	}

	function prepare_artist(){

		$art = $this->artist_name;
		$inicial = $this->letter;
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
			if (file_exists("../images/artists/" . $filename)){
				  $filename = time()."_".$filename;
				  move_uploaded_file($file["tmp_name"],"../images/artists/" . $filename);
				  return $filename;
			  }
			else{
				  move_uploaded_file($file["tmp_name"],"../images/artists/" . $filename);
				  return $filename;
			}
		}

	}

}