<?php

/**
 * @version		1.5.0
 * @package		expedition
 * @copyright	2009 sirpiter.ru
 * @license		GPLv2
 * 
 * Описание таблицы экспедиций __expeditions
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


class TableExpedition extends JTable
{

	var $id = null;

	var $expedition_title = null;
	var $begin_date = null;
	var $end_date = null;
	var $chief_collector = null;
	var $comment = null;
	var $keywords = null;
	var $image_folder = null;
	var $added = null;
	var $year_begin = null;    
	var $month_begin = null;    
	var $month_end = null;    
	var $year_end = null;    
	var $organization_id = null;
    
	
	function TableExpedition(& $db) {
		parent::__construct('#__konsa_exp_expeditions', 'id', $db);
	}


	function check(){
		if($this->id == 0){
		$this->added =  date('Y-m-d H:i:s') ;
		}
		return true;
	}

	function check__(){
		if($this->id == 0){
			$this->added =  date('Y-m-d H:i:s') ;

			$user =& JFactory::getUser();

			$this->user_id = $user->id;

			if($this->edition_year == null && $this->edition_month == null ){
				$this->edition_year = $this->year;
				$this->edition_month = $this->month;
			}

			$artist_keywords = $this->get_artist_keywords($this->artist_id)." ".$this->get_keywords($this->subartist);
			$album_keywords = $this->get_keywords($this->name." ".$this->subtitle);
			$this->keywords = $this->get_keywords($artist_keywords." ".$album_keywords." ".$this->keywords);
		}
		if($this->name_image_file["name"] != ""){
			$success_image=false;
			$success_image = $this->guardarImatgeNomAlbum($this->name_image_file);
			if($success_image) $this->name2 = $success_image;
		}
		if($this->artist_image_file["name"] != ""){
			$success_image=false;
			$success_image = $this->guardarImatgeNomArtista($this->artist_image_file);
			if($success_image) $this->artist2 = $success_image;
		}
		if($this->image_file["name"] != ""){
			$success_image=false;
			$success_image = $this->guardarImatge($this->image_file);
			if($success_image) $this->image = $success_image;
		}

//		$this->tags = implode(",",$this->tags);
//		$this->types = implode(",",$this->types);

		$this->keywords = $this->get_keywords(" ". $this->keywords . " ");

		$this->length = $this->hours * 3600 + $this->minuts * 60 + $this->seconds ;
		$this->hours = null;
		$this->minuts = null;
		$this->seconds = null;

		return true;
	}

	function get_collector_keywords($collector_id){

		$query = " SELECT keywords FROM #__konsa_exp_collectors WHERE id = $collector_id LIMIT 1 ";

		$this->_db->setQuery( $query );
		return $this->_db->loadResult();

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

	function createThumb( $filename , $path , $ample)
	{
		  // load image and get image size
		  $img = imagecreatefromjpeg("../images/expeditions/".$filename);
		  $width = imagesx( $img );
		  $height = imagesy( $img );

		  // calculate thumbnail size
		  $new_width = $ample;
		  $new_height = floor( $height * ( $new_width / $width ) );

		  // create a new temporary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );

		  // copy and resize old image into new image
		  imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		  // save thumbnail into a file

		  imagejpeg( $tmp_img, $path.$filename, 100 );

	}
	
	function guardarImatge($file){
		$filename = $file["name"];

	   if ($file["error"] > 0){
		  return false;
		}
	  else{
		if (file_exists("../images/expeditions/" . $filename)){
			  //message("Ja existeix l'arxiu ".$filename." !","red","Cancel.png",true);
			  $filename = time()."_".$filename;
			  move_uploaded_file($file["tmp_name"],"../images/expeditions/" . $filename);
			  $this->createThumb($filename,"../images/expeditions/thumbs_115/",115); // creem la miniatura de 115px
		  	  $this->createThumb($filename,"../images/expeditions/thumbs_40/",40); // creem la miniatura de 40 px
			  return $filename;
		  }
		else{
		  move_uploaded_file($file["tmp_name"],"../images/expeditions/" . $filename);

		  $this->createThumb($filename,"../images/expeditions/thumbs_115/",115); // creem la miniatura de 115px
		  $this->createThumb($filename,"../images/expeditions/thumbs_40/",40); // creem la miniatura de 40 px
		  return $filename;
		  }
		}
	  }

	function guardarImatgeNomAlbum($file){
		$filename = $file["name"];

	  if ($file["error"] > 0){

		  return false;
		}
	  else{
		if (file_exists("../images/expedition_extra/expedition_name/" . $filename)){

			  $filename = time()."_".$filename;
			  move_uploaded_file($file["tmp_name"],"../images/expedition_extra/expedition_name/" . $filename);

			  return $filename;
		  }
		else{
		  move_uploaded_file($file["tmp_name"],"../images/expedition_extra/expedition_name/" . $filename);
		  return $filename;
		  }
		}
	  }

	function guardarImatgeNomArtista($file){
		$filename = $file["name"];

	  if ($file["error"] > 0){

		  return false;
		}
	  else{
		if (file_exists("../images/expedition_extra/expedition_name/" . $filename)){

			  $filename = time()."_".$filename;
			  move_uploaded_file($file["tmp_name"],"../images/expedition_extra/collector_name/" . $filename);

			  return $filename;
		  }
		else{
		  move_uploaded_file($file["tmp_name"],"../images/expedition_extra/collector_name/" . $filename);
		  return $filename;
		  }
		}
	  }

}