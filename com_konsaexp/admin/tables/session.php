<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014
 * @license		GPLv2
 * 
 * Описание таблицы сессий записи ___konsa_exp_sessions
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


class TableSession extends JTable
{

	var $id = null;
	var $session_code = null;
	var $session_title = null;
	var $date = null;
	var $place_id = null;
	var $expedition_id = null;
	var $comment = null;
	var $keywords = null;
	var $image_folder = null;
	var $added = null;
    
	function TableSession(& $db) {
		parent::__construct('#__konsa_exp_sessions', 'id', $db);
	}

	function check(){
		if($this->id == 0){
			$this->added =  date('Y-m-d H:i:s') ;
			$user =& JFactory::getUser();
			$this->user_id = $user->id;
		}
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
		  $img = imagecreatefromjpeg("../images/sessions/".$filename);
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
}