<?php

/**
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
//echo JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'expeditions.php';
//require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'expeditions.php');

jimport( 'joomla.application.component.model' );

class ExpeditionsModelExpeditions extends JModel
{

    var $_data;
    var $_total = null;
    var $_pagination = null;
    var $_keywords = null;
	var $_collectors_list = null;
	var $_collector_id = null;

	function __construct(){
		parent::__construct();

		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');

		// Get pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		//$limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', '0', 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		 // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$keywords = $mainframe->getUserStateFromRequest('articleelement.keywords','keywords','','keywords');
		$collector_id = $mainframe->getUserStateFromRequest('articleelement.chief_collector','chief_collector',0,'chief_collector');

        $filter_order     = $mainframe->getUserStateFromRequest(  $option.'exp_filter_order', 'filter_order', 'year_begin', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'exp_filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
 
        $this->setState('exp_filter_order', $filter_order);
        $this->setState('exp_filter_order_Dir', $filter_order_Dir);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);

		$this->setState('keywords', $keywords);
		$this->setState('collector_id', $collector_id);
         //  print_r($collector_id); //die();
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
		if (empty($this->_keywords)) {
			$this->_keywords = $this->getState('keywords')	;
		}
		return $this->_keywords;
	}
	function getCollectorId(){
		if (empty($this->_collectort_id)) {
			$this->_collector_id = $this->getState('collector_id')	;
		}
		return $this->_collector_id;
	}

	 function get_where_clause_keywords($keywords){ //germi
	 	// $keywords = utf8_decode(trim($this->get_keywords($keywords)));

		$keyword=explode(" ",$keywords);
		$cadena="";
		for($i=0;$i<sizeof($keyword);$i++){
			$cadena.="(#__konsa_exp_expeditions.expedition_title LIKE '%".$keyword[$i]."%') AND ";
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

		$keywords = $this->getKeywords();
		$collector_id = $this->getCollectorId();

		$where_clause = array();

		if ($keywords != "")
			$where_clause[] = $this->get_where_clause_keywords($keywords);
		if ($collector_id > 0) {
			$where_clause[] = ' exp.chief_collector = '.(int) $collector_id;
		}

		// Build the where clause of the content record query
		$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');

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
						' INNER JOIN #__konsa_exp_expeditions  ON (#__konsa_exp_collectors.id = #__konsa_exp_expeditions.chief_collector) '
					.$where_clause
			.$this->_buildContentOrderBy()
		;
		// print_r($query);//die();

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
/*		$query = "SELECT jos_konsa_exp_expeditions . * , jos_konsa_exp_collectors.collector_full_name
FROM (
jos_konsa_exp_expeditions
LEFT JOIN jos_konsa_exp_collectors ON ( jos_konsa_exp_collectors.id = jos_konsa_exp_expeditions.chief_collector )
)
ORDER BY jos_konsa_exp_expeditions.year_begin DESC ";
	*/		
			$this->_db->setQuery( $query );
	
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
			// traduim els numeros dels types a paraules
//print_r($query);
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

	
	function _buildContentOrderBy()
	{
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');
 
                $orderby = '';
                $filter_order     = $this->getState('exp_filter_order');
                $filter_order_Dir = $this->getState('exp_filter_order_Dir');
 
                // Error handling is never a bad thing
                if(!empty($filter_order) && !empty($filter_order_Dir) ){
                        $orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
                }
 
                return $orderby;
	}
	
		function getExpeditionsData()
	{
		if (empty( $this->_expeditions_data )){
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
						
					
			$this->_db->setQuery( $query );
			$this->_expeditions_data = $this->_db->loadObjectList();
			
		}
		return $this->_expeditions_data;
	}


}

