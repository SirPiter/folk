<?php

/** 
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class ExpeditionsModelSearch extends JModel
{
	  
	function __construct()
	{
		parent::__construct();
		
		$mainframe =& JFactory::getApplication();

		$id = JRequest::getVar('id');
		
		$params = &JComponentHelper::getParams( 'com_konsaexp' );
		
		$default_layout = $params->get( 'layout', 'expeditions_view' );
		
		$layout = $mainframe->getUserStateFromRequest('layout','layout', $default_layout ,'layout');
		$this->setState('layout', $layout);
		
		$this->keywords = JRequest::getVar('searchword');
		$this->collector_id = JRequest::getVar('collectors_id');
		$this->town_id = JRequest::getVar('towns_id');
//		$this->artist_id = JRequest::getVar('artist_id');
		
		// Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
 
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		
		//we won't use limitstart for now
		$limitstart = 0;
 
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
		
	}
	
	function getLayout(){
		if (empty($this->_layout)) {
			$this->_layout = $this->getState('layout')	;
		}
		return $this->_layout;
	}

	function setId($id)
	{
		$this->_albums_data	= null;
		$this->_layout	= $this->getState('layout');
	}
	
	function getTotal(){
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
    }
	
	function getPagination()
  	{
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
  	}

	//if we search songs....we use pagination
	function _buildQuery(){
		if(empty($this->query)){
			
			$keywords = $this->keywords;
			$collector_id = $this->collector_id;
			$town_id = $this->town_id;
			
			$where_clause = array();
	
			if ($keywords != "") $where_clause[] = ' e.expedition_title LIKE "%'.$keywords.'%"';
			
			if ($collector_id > 0) {
				$where_clause[] = ' ( e.chief_collector = '. $collector_id . ' )';
			}
			if ($town_id > 0) {
				$where_clause[] = ' ( e.chief_collector = '. $collector_id . ' )';
			}
			
			// Build the where clause of the content record query
			$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');
			
			$this->query = 	' SELECT s.*,al.name as album_name,al.image, ar.artist_name FROM #__muscol_songs as s '.
							' LEFT JOIN #__muscol_albums as al ON al.id = s.album_id ' .
							' LEFT JOIN #__muscol_artists as ar ON ( ar.id = s.artist_id OR ar.id = al.artist_id ) ' .
							$where_clause .
							' ORDER BY s.artist_id, al.year, al.month, al.id, s.disc_num,s.num '
							;
							//echo $this->query; die();
		}
		return $this->query;
	}
	
	function getSongsData(){
		if (empty( $this->songs_data )) {
			$query = $this->_buildQuery();
			
			$this->songs_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
			
		}
		return $this->songs_data;	
	}

	
	function getSearchword(){
			
		return $this->keywords;
	
	}
	
	function getFormatId(){
			
		return $this->format_id;
	
	}

	function getCollectorId(){
		return $this->collector_id;
	}
	
	function getTownId(){
		return $this->town_id;
	}
	
	function getGenreId(){
			
		return $this->genre_id;
	
	}

	function getTypesArray(){
			if (empty( $this->_types_array )){
				$query = ' SELECT id,type_name FROM #__muscol_type ';
				$this->_db->setQuery( $query );
				$this->_types_array = $this->_db->loadAssocList('id');
			}
			
		return $this->_types_array;
	
	}
	
	function getFormatList(){
			if (empty( $this->format_list )){
				$query = 	' SELECT id,format_name FROM #__muscol_format '.
							' WHERE display_group = 0 ' .
							' ORDER BY order_num ' ;
				$this->_db->setQuery( $query );
				$this->format_list = $this->_db->loadObjectList();
			}
			
		return $this->format_list;
	
	}
	
	function getArtistList(){
			if (empty( $this->artist_list )){
				$query = 	' SELECT id,artist_name FROM #__muscol_artists '.
							' ORDER BY letter,class_name ' ;
				$this->_db->setQuery( $query );
				$this->artist_list = $this->_db->loadObjectList();
			}
			
		return $this->artist_list;
	
	}
	
	function get_where_clause_keywords($keywords){ //germi
	 	$keywords = utf8_decode(trim($this->get_keywords($keywords)));
		
		$keyword=explode(" ",$keywords);
		$cadena="";
		for($i=0;$i<sizeof($keyword);$i++){
			$cadena.="(al.keywords LIKE '% ".$keyword[$i]." %') AND ";
		}
		if($i>0){
			$cadena = substr($cadena,0,-5);
			$cadena = "".$cadena."";
		}
		else if ($i==0) $cadena = "";
		return $cadena;
	 }
	 
	 function get_keywords($keywords){
		return $this->erase_multiple_whitespaces(" ".$keywords." ");
	}

	function erase_multiple_whitespaces($cadena){
		$cadena2 = str_ireplace("  "," ",$cadena,$times);
		if($times!=0) $cadena2 = $this->erase_multiple_whitespaces($cadena2);
		return $cadena2;
	}
	
	function getGenresData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_genres_data )){
				$query = ' SELECT * FROM #__muscol_genres '.
						 ' WHERE parents = "0" '
						 ;
				$this->_db->setQuery( $query );
				$this->_genres_data = $this->_db->loadObjectList();
				
				for($i = 0; $i < count( $this->_genres_data ) ; $i++){
					$this->_genres_data[$i]->sons = $this->get_descendants($this->_genres_data[$i]);	
				}
			}
			
		return $this->_genres_data;
	
	}
	
	function get_descendants($genre){

		$query = 	' SELECT * FROM #__muscol_genres '.
					' WHERE '.
					' ( parents LIKE "%,'.$genre->id.',%"'.
							' OR parents LIKE "'.$genre->id.',%" '.
							' OR parents LIKE "%,'.$genre->id.'" '.
							' OR parents LIKE "'.$genre->id.'" ) '
					;
		$this->_db->setQuery( $query );
		$return = $this->_db->loadObjectList();

		if(!empty( $return )){
			for($i = 0; $i < count( $return ) ; $i++){
				$return[$i]->sons = $this->get_descendants($return[$i]);	
			}

		}
		
		return $return;
		
	}
	
	var $descendantsId = null;
	
	function getDescendantsId($genre){

		$query = 	' SELECT id FROM #__muscol_genres '.
					' WHERE '.
					' ( parents LIKE "%,'.$genre.',%"'.
							' OR parents LIKE "'.$genre.',%" '.
							' OR parents LIKE "%,'.$genre.'" '.
							' OR parents LIKE "'.$genre.'" ) '
					;
		$this->_db->setQuery( $query );
		$return = $this->_db->loadResultArray();
		
		if(!empty( $return )){
			for($i = 0; $i < count( $return ) ; $i++){
				$this->descendantsId[] = $return[$i];
				$this->getDescendantsId($return[$i]);	
			}

		}
		
	}
	
	function getAlbumsData(){

			if (empty( $this->_albums_data )){
				$query = 	' SELECT * FROM #__muscol_format '.
							' WHERE display_group = 0'.
							' ORDER BY order_num ';
				$this->_db->setQuery( $query );
				$this->_albums_data = $this->_db->loadObjectList();
				
				$types_array = $this->getTypesArray();
				
				$keywords = $this->keywords;
				$format_id = $this->format_id;
				$genre_id = $this->genre_id;
				
				$where_clause = array();
		
				if ($keywords != "") $where_clause[] = $this->get_where_clause_keywords($keywords);
				
				if ($format_id > 0) {
					$where_clause[] = ' (al.format_id = '.(int) $format_id . ' OR display_group = '.(int) $format_id . ')';
				}
				if ($genre_id > 0) {
					$genre->id = $genre_id ;
					$this->getDescendantsId($genre_id); 
					$descendants = $this->descendantsId;
					$descendants[] = $genre_id ;
					$genre_clause = ' ( al.genre_id = ' . implode(' OR al.genre_id = ',$descendants) . ' ) ';
					$where_clause[] = $genre_clause;
				}
				
				// Build the where clause of the content record query
				$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');
				
				for($i=0;$i < count($this->_albums_data); $i++){
					
					if ($keywords != ""){
					
					$format_id = $this->_albums_data[$i]->id;
					$query = 	' SELECT f.*,al.*,ar.artist_name,ar.letter,ge.genre_name '.
								' FROM #__muscol_albums as al '.
								' LEFT JOIN #__muscol_artists as ar ON ar.id = al.artist_id '.
								' LEFT JOIN #__muscol_format as f ON f.id = al.format_id '.
								' LEFT JOIN #__muscol_genres as ge ON ge.id = al.genre_id '.
								$where_clause .
								' AND (format_id = '.$format_id.' OR display_group = '.$format_id.')'.
								' AND (part_of_set = 0 OR ( part_of_set != 0 AND show_separately = "Y" ) ) ' .
								' ORDER BY year,month ';
					//echo $query; die();
					$this->_db->setQuery( $query );
					$this->_albums_data[$i]->albums = $this->_db->loadObjectList();
					
					for($j = 0; $j < count($this->_albums_data[$i]->albums); $j++){
						// busquem si hi ha albums que pertanyin a aquest item
						
						$query = 	' SELECT id,name,image '.
									' FROM #__muscol_albums '.
									' WHERE part_of_set = ' . $this->_albums_data[$i]->albums[$j]->id
									;
						$this->_db->setQuery( $query );
						$this->_albums_data[$i]->albums[$j]->subalbums = $this->_db->loadObjectList();		
												
						// i ara les etiquetes
						$tags = explode(",",$this->_albums_data[$i]->albums[$j]->tags);
						for($k = 0; $k < count($tags); $k++){
							if($tags[$k] != ""){
								$query = 	' SELECT tag_name,icon '.
											' FROM #__muscol_tags '.
											' WHERE id = '.$tags[$k];
								$this->_db->setQuery( $query );
								$tags[$k] = $this->_db->loadObject();	
							}
						}
						$this->_albums_data[$i]->albums[$j]->tags = $tags;
						
						// traduim els numeros dels types a paraules
						$this->_albums_data[$i]->albums[$j]->types = explode(",",$this->_albums_data[$i]->albums[$j]->types);
						if(!empty($this->_albums_data[$i]->albums[$j]->types)){
							for($k = 0; $k < count($this->_albums_data[$i]->albums[$j]->types) ; $k++){
								$this->_albums_data[$i]->albums[$j]->types[$k] = JText::_( $types_array[$this->_albums_data[$i]->albums[$j]->types[$k]]["type_name"] );
							}
							
						//mirem la puntuacio Average
						$query = 	' SELECT AVG(points) '.
									' FROM #__muscol_ratings '.
									' WHERE album_id = ' . $this->_albums_data[$i]->albums[$j]->id ;
						
						$this->_db->setQuery( $query );
						$this->_albums_data[$i]->albums[$j]->average_rating = $this->_db->loadResult();
						
						
						//mirem quantes cançons hi ha
						$query = 	' SELECT COUNT(*) '.
									' FROM #__muscol_songs '.
									' WHERE album_id = ' . $this->_albums_data[$i]->albums[$j]->id ;
						
						$this->_db->setQuery( $query );
						$this->_albums_data[$i]->albums[$j]->num_songs = $this->_db->loadResult();
						
						
						//mirem quants comentaris hi ha
						$params = &JComponentHelper::getParams( 'com_muscol' );
						switch($params->get('commentsystem')){ 
							
							case 'jomcomment':
								 $query = 	' SELECT COUNT(*) '.
											' FROM #__jomcomment '.
											' WHERE contentid = ' . ( 100000000 + $this->_albums_data[$i]->albums[$j]->id ) . ' AND `option` = "com_muscol" ' ;
								
								$this->_db->setQuery( $query );
								$this->_albums_data[$i]->albums[$j]->num_comments = $this->_db->loadResult();
								
								 break;
							default:
								$query = 	' SELECT COUNT(*) '.
											' FROM #__muscol_comments '.
											' WHERE album_id = ' . $this->_albums_data[$i]->albums[$j]->id ;
								
								$this->_db->setQuery( $query );
								$this->_albums_data[$i]->albums[$j]->num_comments = $this->_db->loadResult();
							break;
						}
						
						}
										
					}
					
					}
				}
			}
			
		return $this->_albums_data;
	
	}


	function getCollectorsList()
	{
		if (empty( $this->_collectors_list )){

			$query = 	' SELECT id,collector_full_name '
					. ' FROM #__konsa_exp_collectors '
					.' ORDER BY collector_lastname'
					;

			$this->_db->setQuery( $query );
			$this->_collectors_list = $this->_db->loadAssocList();
		}

 	return $this->_collectors_list;
	}
	
	function getTownsList()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_towns )){
				$query = ' SELECT id,town_name FROM #__konsa_exp_towns '.
						 ' ORDER BY town_name';
				$this->_db->setQuery( $query );
				$this->_towns = $this->_db->loadObjectList();
			}
			
		return $this->_towns;
	}


	
	function getExpeditionsData()
	{
		if (empty( $this->_expeditions_data )){
			$query = 	' SELECT * FROM #__konsa_exp_expeditions '.
						' ORDER BY begin_date ';
						
						
			$query = 	' SELECT exp.* , coll.* FROM #__konsa_exp_expeditions as exp '.
						' INNER JOIN #__konsa_exp_collectors as coll ON (exp.chief_collector = coll.id) '.
						' ORDER BY exp.begin_date '; 
						
			$query = 	' SELECT #__konsa_exp_expeditions.id, '.
						' #__konsa_exp_expeditions.expedition_title, '.
						' #__konsa_exp_expeditions.begin_date, '.
						' #__konsa_exp_expeditions.end_date, '.
						' #__konsa_exp_expeditions.chief_collector, '.
						' #__konsa_exp_expeditions.year_begin, '.
						' #__konsa_exp_collectors.collector_name, '.
						' #__konsa_exp_collectors.collector_lastname, '.
						' #__konsa_exp_collectors.collector_full_name '.
						' FROM  #__konsa_exp_collectors '.
						' INNER JOIN #__konsa_exp_expeditions  ON (#__konsa_exp_collectors.id = #__konsa_exp_expeditions.chief_collector) ';
						
			$keywords = $this->keywords;
			$collector_id = $this->collectors_id;
			$town_id = $this->towns_id;
			
			//print_r($keywords);
			//print_r($this->collector_id);
			
			$where_clause = array();
	
			if ($keywords != "") $where_clause[] = ' #__konsa_exp_expeditions.expedition_title LIKE "%'.$keywords.'%"';
			
			if ($this->collector_id > 0) {
				$where_clause[] = ' ( #__konsa_exp_expeditions.chief_collector = '. $this->collector_id . ' )';
			}

			// Build the where clause of the content record query
			$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');
			$query .=  $where_clause;
						
			$this->_db->setQuery( $query );
			$this->_expeditions_data = $this->_db->loadObjectList();
			//print_r($query);
			//print_r($this->_expeditions_data);
			
		}
		return $this->_expeditions_data;
	}


}