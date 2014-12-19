<?php

/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014
 * @license		GPLv2
 */


// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );
jimport('joomla.application.component.modellist'); // 2.5


class SessionsModelSessions extends JModel
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
		$limitstart = $mainframe->getUserStateFromRequest($this->option.'.sessions_limitstart', 'limitstart', 0, 'int');

		$keywords = $mainframe->getUserStateFromRequest('articleelement.sessions_keywords','keywords','','keywords');
		$collector_id = $mainframe->getUserStateFromRequest('articleelement.chief_collector','chief_collector',0,'chief_collector');

        $filter_order     = $mainframe->getUserStateFromRequest(  $this->option.'exp_filter_order', 'filter_order', 'year_begin', 'cmd' );
        $filter_order_Dir = $mainframe->getUserStateFromRequest( $this->option.'exp_filter_order_Dir', 'filter_order_Dir', 'asc', 'word' );
 
        $this->setState('exp_filter_order', $filter_order);
        $this->setState('exp_filter_order_Dir', $filter_order_Dir);

		$this->setState('limit', $limit);
		$this->setState('sessions_limitstart', $limitstart);

		$this->setState('sessions_keywords', $keywords);
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
 	    $this->_pagination = new JPagination($this->getTotal(), $this->getState('sessions_limitstart'), $this->getState('limit') );
 	}
 	return $this->_pagination;
  }


	function getKeywords(){
		if (empty($this->_keywords)) {
			$this->_keywords = $this->getState('sessions_keywords')	;
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
	// 	$keywords = utf8_decode(trim($this->get_keywords($keywords)));

		$keyword=explode(" ",$keywords);
		$cadena="";
		for($i=0;$i<sizeof($keyword);$i++){
			$cadena.="((#__konsa_exp_sessions.session_title LIKE '%".$keyword[$i]."%') OR (#__konsa_exp_collectors.collector_full_name LIKE '%".$keyword[$i]."%' )) AND ";
		}
		
	//	print_r($cadena);
		
		
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

		
		// Получаем объект запросов (JDatabaseQuery)
		//$query = $this->_db->getQuery(true);
		
		$keywords = $this->getKeywords();
		$collector_id = $this->getCollectorId();

		$where_clause = array();

		if ($keywords != "")
			$where_clause[] = $this->get_where_clause_keywords($keywords);
		if ($collector_id > 0) {
	//		$where_clause[] = ' #__konsa_exp_sessions.chief_collector = '.(int) $collector_id;
		}

		// Build the where clause of the content record query
		$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');

		$query = ' SELECT #__konsa_exp_sessions.*, #__konsa_exp_towns.town_name '
				. ' FROM #__konsa_exp_sessions '
				.' LEFT JOIN #__konsa_exp_towns ON #__konsa_exp_sessions.place_id = #__konsa_exp_towns.id ';
		// $query = ' SELECT #__konsa_exp_sessions.*  FROM #__konsa_exp_sessions ' ;
		
		//Опреднляем таблицу
/*		$query->select('*');
		$query->from($this->_db->quoteName('#__konsa_exp_sessions'), 'sessions');
		// Присоединяем #__towns
		$query->select($this->_db->quoteName('towns.town_name'));
		$query->leftJoin(
				$this->_db->quoteName('#__konsa_exp_towns', 'towns')
				. ' ON '
				. $this->_db->quoteName('towns.id')
				. ' = ' . $this->_db->quoteName('sessions.place_id')
		);
		*/
		
		//$query->join('LEFT OUTER', '#__konsa_exp_towns ON #__konsa_exp_sessions.place_id = #__konsa_exp_towns.id');
		
		//	.$where_clause
		//	.$this->_buildContentOrderBy()
		//;
  	//		.' LEFT JOIN #__konsa_exp_format as f ON f.id = al.format_id '

		//print_r($query); //die();

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
			// print_r($query);
			$this->_data = $this->_getList($query, $this->getState('sessions_limitstart'), $this->getState('limit'));
		}

 	return $this->_data;
	}

	function getCollectorsList()
	{
		
		if (empty( $this->_collectors_list )){
			$query = 	' SELECT id,collector_lastname '
					. ' FROM #__konsa_exp_collectors '
					.' ORDER BY letter'
					;

			$query = ' SELECT exp.session_title,col.* '
				. ' FROM #__konsa_exp_collectors as col '
				.' INNER JOIN #__konsa_exp_sessions as exp ON col.id = exp.chief_collector '
				;


			$this->_db->setQuery( $query );
			$this->_collectors_list = $this->_db->loadAssocList();
		}

 	return $this->_collectors_list;

	}
	
	function _buildContentOrderBy()
	{
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');
 
                $orderby = '';
                $filter_order     = $this->getState('exp_filter_order');
                $filter_order_Dir = $this->getState('exp_filter_order_Dir');
 
                /* Error handling is never a bad thing*/
                if(!empty($filter_order) && !empty($filter_order_Dir) ){
                        $orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
                }
 
                return $orderby;
	}
}