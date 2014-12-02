<?php

/** 
 * @version		1.5.0
 * @package		muscol
 * @copyright	2009 JoomlaMusicSolutions.com
 * @license		GPLv2
 */
class MusColHelper{
	
function show_stars($points,$admin = false,$album_id = false,$ajax=false,$small=false){
		$grey="";
		$show_small = "";
		$return = "";
		if($ajax) $funcio = "puntua";
		else $funcio = "canvia_estrelles";
		/*
		if($admin) $text = "Owner's Rating";
		else $text = "User's average Rating";
		*/
		if($small) $show_small = "_small";
		
		$points = round($points * 2) / 2;
		
		for($i=1;$i<6;$i++){
			if($i > $points){
				$grey = "_grey";
				if($points > ($i-1)) $grey = "_half_grey";
			}
			
			$image_attr = array(
								"title" => "$points ".JText::_('out of')." 5"
								);
			
			$image_attr_java = array(
								"title" => "$points ".JText::_('out of')." 5" ,
								"id" => "star".$i."_".$album_id ,
								//"onclick" => $funcio."($i,$album_id);" ,
								"onmouseover" => "stars($i,$album_id);"
								);
			
			if($album_id) {
				$image_attr = $image_attr_java;
				$return .= "<a href='".JURI::root(true)."/index.php?option=com_muscol&task=rate&album_id=$album_id&points=$i'>".JHTML::image('components/com_muscol/assets/images/star' . $grey.$show_small. '.png' , "$i ".JText::_('out of')." 5" , $image_attr )."</a>";
	
			}
			else{
				$return .= JHTML::image('components/com_muscol/assets/images/star' . $grey.$show_small. '.png' , "$points ".JText::_('out of')." 5" , $image_attr );
			}
		}
		return $return;
	}
	
	function li_inicial($lletra,$selected,$pos){
		$cadena = "";
		if($selected){
			if($pos=="") $cadena .= "<li class='selected'>";
			else if($pos=="left") $cadena .= "<li class='left_selected'>";
			else if($pos=="right") $cadena .= "<li class='right_selected'>";
		}
		else{
			if($pos=="") $cadena .= "<li>";
			else if($pos=="left") $cadena .= "<li class='left'>";
			else if($pos=="right") $cadena .= "<li class='right'>";
		}
		
		$link = JRoute::_( 'index.php?option=com_muscol&view=artists&letter='. substr($lletra,0,1) . $this->itemid);
		$cadena .= "<a href='".$link."'>".$lletra." </a></li>\n";
		return $cadena;
	}
	
	function month_name($month){
		$month_array = array(
			 1 => JText::_( "January" ), 
			 2 => JText::_( "February" ), 
			 3 => JText::_( "March" ), 
			 4 => JText::_( "April" ), 
			 5 => JText::_( "May" ), 
			 6 => JText::_( "June" ), 
			 7 => JText::_( "July" ), 
			 8 => JText::_( "August" ), 
			 9 => JText::_( "September" ), 
			 10 => JText::_( "October" ), 
			 11 => JText::_( "November" ), 
			 12 => JText::_( "December" ) );
		return $month_array[$month];
	}
	
	function letter_navigation($inicial){
		
		$params = &JComponentHelper::getParams( 'com_muscol' );
		$this->itemid = $params->get('itemid');
		if($this->itemid != "") $this->itemid = "&Itemid=" . $this->itemid;
	
		$return .= "<ul class='inicials'>";

		$inicials = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","123");
		
		if($inicials[0] != $inicial) $return .= MusColHelper::li_inicial($inicials[0],false,"left");
		else $return .= MusColHelper::li_inicial($inicials[0],true,"left");
		
		for($i=1;$i<sizeof($inicials)-1;$i++){
			if($inicials[$i] != $inicial) $return .= MusColHelper::li_inicial($inicials[$i],false,"");
			else $return .= MusColHelper::li_inicial($inicials[$i],true,"");
		}
		
		if(substr($inicials[sizeof($inicials)-1], 0, 1) != $inicial) 
			$return .= MusColHelper::li_inicial($inicials[sizeof($inicials)-1],false,"right");
		else $return .= MusColHelper::li_inicial($inicials[sizeof($inicials)-1],true,"right");

		$return .= "</ul>";
		
		return $return;
	}
	
	function time_to_string($total_time){
	 
	  $segons = $total_time % 60;
	  
	  if($segons < 10) $segons = "0".$segons;
	  
	  $minuts = ($total_time - $segons)/60;
	  
	  if($minuts >= 60){
	  $minuts_60 = $minuts % 60;
	  $hores = ($minuts - $minuts_60)/60;
	   if($minuts_60 < 10) $minuts_60 = "0".$minuts_60;
	  }
	  else $hores=0;
	  
	  if($hores>0){
	  $total_time = $hores.":".$minuts_60.":".$segons;
	  }
	  else $total_time = $minuts.":".$segons;
	  
	  return $total_time;
	}
	
	function createThumbnail($file, $alt, $width, $image_attr = array(), $params = array()){
		
		$params = &JComponentHelper::getParams( 'com_muscol' );
		if($params->get('thumbs_mode')){
			return JHTML::image('components/com_muscol/helpers/images/image.php?file=' .JPATH_SITE.DS.'images'.DS.'albums'.DS. $file .'&width=' . $width, $alt , $image_attr );
		}else{
			if($width < 60) return JHTML::image('images/albums/thumbs_40/' . $file, $alt , $image_attr );
			else return JHTML::image('images/albums/thumbs_115/' . $file, $alt , $image_attr );
		}
		
	}
	
	function showMusColFooter(){
		return "<a href='http://www.joomlamusicsolutions.com' title='Music Collection: The Joomla! Music Management System' target='_blank'>Powered by Music Collection for Joomla!</a>";
	}
	
	function create_file_link($song){
		
		$file_link = JRoute::_( 'index.php?option=com_muscol&view=file&format=raw&id='. $song->id );
		
		$uri =& JFactory::getURI();
		$dirname = $this->params->get('songspath');
		if(substr($dirname, 0, 1) == "/") $dirname = substr($dirname, 1);
		if(substr($dirname, -1) != "/") $dirname = $dirname . "/";
		
		$base_path = $this->params->get('songsserver');
		
		if($base_path == "") $base_path = $uri->base() ;
		
		if(substr($base_path, -1) != "/") $base_path = $base_path . "/";
		
		$song_base = $base_path . $dirname ;
		
		$song->filename = str_replace($song_base, "", $song->filename) ;
			
		if(strpos($song->filename,"://")){
			
			if(!strpos($song->filename,"://")) $song_path_complet = $song_base . $song->filename ;
			else $song_path_complet = $song->filename ;
			
			$file_link = $song_path_complet ;
		}
		return $file_link;
	}
	
}


class KonsaExpHelper{
	function month_name($month){
		$month_array = array(
			 1 => JText::_( "January" ), 
			 2 => JText::_( "February" ), 
			 3 => JText::_( "March" ), 
			 4 => JText::_( "April" ), 
			 5 => JText::_( "May" ), 
			 6 => JText::_( "June" ), 
			 7 => JText::_( "July" ), 
			 8 => JText::_( "August" ), 
			 9 => JText::_( "September" ), 
			 10 => JText::_( "October" ), 
			 11 => JText::_( "November" ), 
			 12 => JText::_( "December" ) );
		return $month_array[$month];
	}
	
	function showKonsaExpFooter(){
		return "<a href='http://konsa.sirpiter.ru' title='Expeditions Archive: The Joomla! Arhive Management System' target='_blank'>Expeditions Archive for Joomla!</a>";
	}
	
}