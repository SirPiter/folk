<?php

/**
* @version		2.5.4
 * @package		konsaexp
 * @copyright	2014 SP
 * @license		GPLv2
  */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class PhotosModelPhotos extends JModel
{

	var $_data;
  	var $_total = null;
  	var $_pagination = null;
  	var $_keywords = null;
  	var $_photo_id = null;

	function __construct(){
		parent::__construct();

		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');

		// Get pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.'.photos_limitstart', 'limitstart', 0, 'int');

		$keywords = $mainframe->getUserStateFromRequest('articleelement.photos_keywords','keywords','','keywords');
		$region_id = $mainframe->getUserStateFromRequest('articleelement.photo','photo',0,'region');

		$this->setState('limit', $limit);
		$this->setState('photos_limitstart', $limitstart);
		$this->setState('photo_id', $photo_id);
		$this->setState('photos_keywords', $keywords);
		
		$filter_order     = $mainframe->getUserStateFromRequest( $option.'photos_filter_order', 'filter_order', 'title', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'photos_filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
        $this->setState('photos_filter_order', $filter_order);
        $this->setState('photos_filter_order_Dir', $filter_order_Dir);


  	}


	function _buildQuery()
	{

		$keywords = $this->getKeywords();
		$region_id = $this->getRegionId();
		
		$where_clause = array();

		if ($keywords != "")
			$where_clause[] = $this->get_where_clause_keywords($keywords);
		if ($doc_id > 0) {
			$where_clause[] = ' doc = '.(int) $photo_id;
		}

		// Build the where clause of the content record query
		$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');

		$query = ' SELECT * '
				. ' FROM #__konsa_exp_photos '
			.$where_clause
			.$this->_buildContentOrderBy()
			;
		//print_r($query);
		return $query;
	}

	function getData()
	{
		if (empty( $this->_data )){
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('photos_limitstart'), $this->getState('limit'));
		}
		return $this->_data;
	}

	function getRegionsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_regions_data )){
				$query = 	' SELECT * FROM #__konsa_exp_regions '.
						 	' ORDER BY region_name ';

				$this->_db->setQuery( $query );
				$this->_regions_data = $this->_db->loadAssocList();
			}
		return $this->_regions_data;
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
 	    $this->_pagination = new JPagination($this->getTotal(), $this->getState('photos_limitstart'), $this->getState('limit') );
 	}
 	return $this->_pagination;
  }


	function getKeywords(){
		if (empty($this->_keywords)) {
			$this->_keywords = $this->getState('photos_keywords')	;
		}
		return $this->_keywords;
	}

	 function get_where_clause_keywords($keywords){ //germi
//	 	$keywords = utf8_decode(trim($this->get_keywords($keywords)));
	 	$keywords = trim($this->get_keywords($keywords));

		$keyword=explode(" ",$keywords);
		$cadena="";
		for($i=0;$i<sizeof($keyword);$i++){
			$cadena.="((title LIKE '%".$keyword[$i]."%') OR (comment LIKE '%".$keyword[$i]."%') OR (short_description LIKE '%".$keyword[$i]."%') OR (description LIKE '%".$keyword[$i]."%')) AND ";
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

	function getRegionId(){
		if (empty($this->_region_id)) {
			$this->_region_id = $this->getState('region_id')	;
		}
		return $this->_region_id;
	}

	function _buildContentOrderBy()
	{
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');
        $orderby = '';
        $filter_order     = $this->getState('photos_filter_order');
        $filter_order_Dir = $this->getState('photos_filter_order_Dir');
 
                /* Error handling is never a bad thing*/
        if(!empty($filter_order) && !empty($filter_order_Dir) ){
            $orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
         }
         return $orderby;
	}

}
