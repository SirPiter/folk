<?php

/**
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class ArtistsModelArtists extends JModel
{

	var $_data;
	var $_total = null;
	var $_pagination = null;
	var $_letters_list = null;
	var $_letter = null;

	function __construct(){
		parent::__construct();

		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');
	//	print_r($this->option);
		

		// Get pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.'.artists_limitstart', 'limitstart', 0, 'int');
		
		$keywords = $mainframe->getUserStateFromRequest('articleelement.artists_keywords','keywords','','keywords');
		$letter = $mainframe->getUserStateFromRequest('articleelement.letter','letter','','letter');

		$filter_order     = $mainframe->getUserStateFromRequest( $option.'artists_filter_order', 'filter_order', 'artist_name', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'artists_filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
        $this->setState('artists_filter_order', $filter_order);
        $this->setState('artists_filter_order_Dir', $filter_order_Dir);
	
//		print_r($filter_order);

		$this->setState('limit', $limit);
		$this->setState('artists_limitstart', $limitstart);
		$this->setState('letter', $letter);
		$this->setState('artists_keywords', $keywords);
//		$this->setState('artist_id', $artist_id);
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
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('artists_limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	  }

	function _buildQuery()
	{
		$letter = $this->getLetter();
		$where_clause = array();
		$keywords = $this->getKeywords();

		if ($keywords != "")
			$where_clause[] = $this->get_where_clause_keywords($keywords);

		if ($letter != "") {
			$where_clause[] = ' letter = "'.$letter.'"';
		}
		// Build the where clause of the content record query
		$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');
  /*
		$query = ' SELECT * '
			. ' FROM #__konsa_exp_artists '
			.$where_clause
			. ' ORDER BY letter,class_name '
		;
  */
    $query = ' SELECT #__konsa_exp_artists.*, #__konsa_exp_towns.town_name '
			. ' FROM  #__konsa_exp_artists LEFT JOIN #__konsa_exp_towns ON #__konsa_exp_artists.place = #__konsa_exp_towns.id '
			.$where_clause
			. $this->_buildContentOrderBy()
			;

	/*		. ' FROM #__konsa_exp_artists '
			. ' town_name
			.$where_clause
			. ' ORDER BY letter,class_name '
		; */

//print_r($query); die;
		return $query;
	}

	function getData(){
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data )){
			$query = $this->_buildQuery();
			// print_r($query);
			$this->_data = $this->_getList($query, $this->getState('artists_limitstart'), $this->getState('limit'));
		}
 	return $this->_data;
	}

	function getLetter(){
		if (empty($this->_letter)) {
			$this->_letter = $this->getState('letter')	;
		}
		return $this->_letter;
	}

	function getLettersList()
	{
		if (empty( $this->_letters_list )){
			$query = ' SELECT DISTINCT letter '
			. ' FROM #__konsa_exp_artists '
			.' ORDER BY letter '
			;
			$this->_db->setQuery( $query );
			$this->_letters_list = $this->_db->loadAssocList();
		}

 	return $this->_letters_list;

	}
	
	function _buildContentOrderBy()
	{
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');

 	       $orderby = '';
        	$filter_order     = $this->getState('artists_filter_order');
	        $filter_order_Dir = $this->getState('artists_filter_order_Dir');
 
	     /* Error handling is never a bad thing*/
        	if(!empty($filter_order) && !empty($filter_order_Dir) ){
	        	$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
	        }
        	return $orderby;
	}

	function getKeywords(){
		if (empty($this->_keywords)) {
			$this->_keywords = $this->getState('artists_keywords')	;
		}
		return $this->_keywords;
	}

	 function get_where_clause_keywords($keywords){ //germi
//	 	$keywords = utf8_decode(trim($this->get_keywords($keywords)));
	 	$keywords = trim($this->get_keywords($keywords));

		$keyword=explode(" ",$keywords);
		$cadena="";
		for($i=0;$i<sizeof($keyword);$i++){
			$cadena.="((#__konsa_exp_artists.artist_full_name LIKE '%".$keyword[$i]."%') OR (#__konsa_exp_towns.town_name LIKE '%".$keyword[$i]."%')) AND ";
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



}