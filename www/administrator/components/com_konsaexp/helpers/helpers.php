<?

/**
 * @version	2.5.0
 * @package	konsaexp
 * @copyright	2012
 * @license	GPLv2
 */

class KonsaExpHelper{
	
	function show_stars($points,$admin = false,$album_id = false,$ajax=false,$small=false){
		$grey="";//"_".$points;
		$src = "";
		$show_small = "";
		$return = "";
		if($ajax) $funcio = "puntua";
		else $funcio = "canvia_estrelles";
		
		if($admin) $src = "../";
		if($small) $show_small = "_small";
		
		for($i=1;$i<6;$i++){
			if($i > $points) $grey="_grey";
			$java = "id='star".$i."_".$album_id."' onclick='".$funcio."($i,$album_id);' onmouseover='stars($i,$album_id);' ";
			$add_java = "";
			if($album_id) $add_java = $java;
			$return .= "<img ".$add_java."src='".$src."components/com_konsa_exp/assets/images/star".$grey.$show_small.".png'/>";
		}
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
		
		$params = &JComponentHelper::getParams( 'com_konsa_exp' );
		if($params->get('thumbs_mode')){
			return JHTML::image('components/com_konsa_exp/helpers/images/image.php?file=' .JPATH_SITE.DS.'images'.DS.'albums'.DS. $file .'&width=' . $width, $alt , $image_attr );
		}else{
			if($width < 60) return JHTML::image('images/albums/thumbs_40/' . $file, $alt , $image_attr );
			else return JHTML::image('images/albums/thumbs_115/' . $file, $alt , $image_attr );
		}
		//image.php?file=image2.jpg&width=200&height=100&corner_radius=20&corner_background=%23ff9900&corner_antialias=1&corner_position=inner&border_thickness=10&border_position=inside&border_color=%23ffffff&resizing_method=fit&image_alignment=center&jpeg_quality=100&background_color=%23000000
		
	}
	
	
	function getExpeditionsList()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_expeditions_list )){
			$query = ' SELECT id,expedition_title FROM #__konsa_exp_expeditions '.
					' ORDER BY expedition_title';
			$this->_db->setQuery( $query );
			$this->_expeditions_list = $this->_db->loadObjectList();
			//print_r($query);  die;
		}
		return $this->_expeditions_list;
	}
	
	
	
}