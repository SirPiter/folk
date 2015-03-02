<?php

/**
 * @version		2.5.0
 * @package		konsaexp
 * @copyright		2012
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//echo JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'expeditions.php';
//require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'expeditions.php');

jimport( 'joomla.application.component.model' );

class ExpeditionsModelArtists extends JModel
{

    var $_data;
    var $_total = null;
    var $_pagination = null;
    var $_keywords = null;
	var $_artists_list = null;
	var $_artist_id = null;

	function __construct(){
		parent::__construct();

		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');

		$this->keywords = JRequest::getVar('searchword');


		// Get pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		//$limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', '0', 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		 // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$keywords = $mainframe->getUserStateFromRequest('articleelement.keywords','keywords','','keywords');
	//	$artist_id = $mainframe->getUserStateFromRequest('articleelement.chief_artist','chief_artist',0,'chief_artist');

        $filter_order     = $mainframe->getUserStateFromRequest(  $this->option.'col_filter_order', 'filter_order', 'artist_full_name', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $this->option.'col_filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
 
        $this->setState('col_filter_order', $filter_order);
        $this->setState('col_filter_order_Dir', $filter_order_Dir);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

		$this->setState('keywords', $keywords);
		$this->setState('artist_id', $artist_id);
         //  print_r($artist_id); //die();
	//	 print_r($this->getState('keywords')); die;

  	}


function getTotal()
  {
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


	function getKeywords(){
	//	echo "getkey";
		if (empty($this->_keywords)) {
			$this->_keywords = $this->getState('keywords')	;
		}
	//print_r($this->_keywords); //die;
		return $this->_keywords;
	}
	function getArtistId(){
		if (empty($this->_artistt_id)) {
			$this->_artist_id = $this->getState('artist_id')	;
		}
		return $this->_artist_id;
	}

	 function get_where_clause_keywords($keywords){ //germi
	 //	$keywords = utf8_decode(trim($this->get_keywords($keywords)));

		$keyword=explode(" ",$keywords);
		$cadena="";
		for($i=0;$i<sizeof($keyword);$i++){
			$cadena.="(#__konsa_exp_artists.artist_full_name LIKE '%".$keyword[$i]."%') AND ";
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

	function _buildQuery()
	{



		//$keywords = $this->keywords;
		$keywords = $this->getKeywords();
		//$artist_id = $this->getArtistId();
		$artist_id = $this->getArtistId();
		//print_r($keywords); //die;		
		$where_clause = array();

		if ($keywords != "")
			$where_clause[] = $this->get_where_clause_keywords($keywords);
		if ($artist_id > 0) {
			$where_clause[] = ' exp.chief_artist = '.(int) $artist_id;
		}

		// Build the where clause of the content record query
		$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');

			$query = ' SELECT #__konsa_exp_artists.*, '.
					 ' #__konsa_exp_towns.town_name as name_place_of_birth, '.
					 ' towns1.town_name as name_place, '.
					 ' towns2.town_name as name_place_of_death '.
					 ' FROM #__konsa_exp_artists '.
					 ' LEFT OUTER JOIN #__konsa_exp_towns ON (#__konsa_exp_artists.place_of_birth = #__konsa_exp_towns.id) '.
					 ' LEFT OUTER JOIN #__konsa_exp_towns as towns1 ON (#__konsa_exp_artists.place = towns1.id) '.
					 ' LEFT OUTER JOIN #__konsa_exp_towns as towns2 ON (#__konsa_exp_artists.place_of_death = towns2.id) '
			.$where_clause
			.$this->_buildContentOrderBy()
		;
  	//		.' LEFT JOIN #__konsa_exp_format as f ON f.id = al.format_id '

		//print_r($query);//die();

		return $query;
	}

	function getTypesArray(){
			if (empty( $this->_types_array )){
				$query = ' SELECT id,type_name FROM #__konsa_exp_type ';
				$this->_db->setQuery( $query );
				$this->_types_array = $this->_db->loadAssocList('id');
			}

		return $this->_types_array;

	}

	function getData(){

		if (empty( $this->_data )){
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
			// traduim els numeros dels types a paraules

			if($this->_data){
				$types_array = $this->getTypesArray();

				for($i = 0; $i < count($this->_data) ; $i++){
					$this->_data[$i]->types = explode(",",$this->_data[$i]->types);

					if(!empty($this->_data[$i]->types)){
						for($j = 0; $j < count($this->_data[$i]->types) ; $j++){
							$this->_data[$i]->types[$j] = JText::_( $types_array[$this->_data[$i]->types[$j]]["type_name"] );
						}
					}
				}
			}     
		}

 	return $this->_data;
	}

	function getArtistsList()
	{
		if (empty( $this->_artists_list )){

			$query = 	' SELECT id,artist_full_name '
					. ' FROM #__konsa_exp_artists '
					.' ORDER BY artist_lastname'
					;

			$this->_db->setQuery( $query );
			$this->_artists_list = $this->_db->loadAssocList();
		}

 	return $this->_artists_list;
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

	
	function _buildContentOrderBy()
	{
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');
 
                $orderby = '';
                $filter_order     = $this->getState('col_filter_order');
                $filter_order_Dir = $this->getState('col_filter_order_Dir');
 
                // Error handling is never a bad thing
                if(!empty($filter_order) && !empty($filter_order_Dir) ){
                        $orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
                }
 
                return $orderby;
	}
	
	function getArtistsData()
	{
		if (empty( $this->_artists_data )){
			$query = $this->_buildQuery();					
			$this->_db->setQuery( $query );
			$this->_artists_data = $this->_db->loadObjectList();
			
		}
		//print_r($query);
//		print_r($this->_artists_data);
		return $this->_artists_data;
	}

	function getSearchword(){
			
		return $this->keywords;
	
	}


}

