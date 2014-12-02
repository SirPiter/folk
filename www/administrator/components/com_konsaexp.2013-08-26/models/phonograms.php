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

class PhonogramsModelPhonograms extends JModel
{

	var $_data;
  	var $_total = null;
  	var $_pagination = null;
  	var $_keywords = null;

	function __construct(){
		parent::__construct();

		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');

		// Get pagination request variables
		$phonograms_limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$phonograms_limitstart = $mainframe->getUserStateFromRequest($option.'.phonograms_limitstart', 'limitstart', 0, 'int');

		// In case limit has been changed, adjust it
       // $phonograms_limitstart = ($limit != 0 ? (floor($phonograms_limitstart / $limit) * $limit) : 0);
		$phonograms_keywords = $mainframe->getUserStateFromRequest('articleelement.phonograms_keywords','keywords','','keywords');
		$this->setState('phonograms_limit', $phonograms_limit);
		$this->setState('phonograms_limitstart', $phonograms_limitstart);

		$this->setState('phonograms_keywords', $phonograms_keywords);
  	}

	function _buildQuery()
	{
		
		$keywords = $this->getKeywords();
		$where_clause = array();

//		$query = 	' SELECT * '.
//			 		' FROM #__konsa_exp_phonograms '
			;
		if ($keywords != "")
			$where_clause[] = $this->get_where_clause_keywords($keywords);

// Build the where clause of the content record query
		$where_clause = (count($where_clause) ? ' WHERE '.implode(' AND ', $where_clause) : '');
				
		$query = ' SELECT ' 
				.'  #__konsa_exp_phonograms.id, ' 
				.' #__konsa_exp_phonograms.phonogram_title, ' 
				.' #__konsa_exp_phonograms.collector_id,  ' 
				.' #__konsa_exp_phonograms.expedition_id, ' 
				.' #__konsa_exp_phonograms.town_id, ' 
				.' #__konsa_exp_phonograms.recorddate, ' 
				.' #__konsa_exp_phonograms.soundfile, ' 
				.' #__konsa_exp_phonograms.textfile, ' 
				.' #__konsa_exp_phonograms.`text`, ' 
				.' #__konsa_exp_phonograms.`comment`, ' 
				.' #__konsa_exp_expeditions.expedition_title, ' 
				.' #__konsa_exp_towns.town_name '
				.' FROM ' 
				.' #__konsa_exp_expeditions ' 
				.' RIGHT OUTER JOIN #__konsa_exp_phonograms ON (#__konsa_exp_expeditions.id = #__konsa_exp_phonograms.expedition_id) '
				.' LEFT OUTER JOIN #__konsa_exp_towns ON (#__konsa_exp_phonograms.town_id = #__konsa_exp_towns.id) '
				.$where_clause
				; //. $this->_buildContentOrderBy()
			//; //.' ORDER BY region_name '
			
	//	print_r($query);

		return $query;
	}

	function getData()
	{
		if (empty( $this->_phonogramsdata )){
			$query = $this->_buildQuery();
			$this->_phonogramsdata = $this->_getList($query, $this->getState('phonograms_limitstart'), $this->getState('phonograms_limit'));
		}
		return $this->_phonogramsdata;
	}

	function getTownsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_towns_data )){
				$query = 	' SELECT * FROM #__konsa_exp_towns '.
						 	' ORDER BY id ';
				$this->_db->setQuery( $query );
				$this->_towns_data = $this->_db->loadObjectList();
			}
		return $this->_towns_data;
	}

	function getExpeditionsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_expeditions_data )){
				$query = 	' SELECT * FROM #__konsa_exp_expeditions '.
						 	' ORDER BY id ';
				$this->_db->setQuery( $query );
				$this->_expeditions_data = $this->_db->loadObjectList();
			}
		return $this->_expeditions_data;
	}



function getTotal()
  {
 	// Load the content if it doesn't already exist
 	if (empty($this->_phonogramstotal)) {
 	    $query = $this->_buildQuery();
 	    $this->_phonogramstotal = $this->_getListCount($query);
 	}
 	return $this->_phonogramstotal;
  }

 function getPagination()
  {
 	// Load the content if it doesn't already exist
 	if (empty($this->_phonogramspagination)) {
 	    jimport('joomla.html.pagination');
 	    $this->_phonogramspagination = new JPagination($this->getTotal(), $this->getState('phonograms_limitstart'), $this->getState('phonograms_limit') );
 	}
//	$this->setState('phonograms_limitstart', $this->_phonogramspagination->limitstart);

 	return $this->_phonogramspagination;
  }


	function getKeywords(){
//		if (empty($this->_keywords)) {
			$this->_keywords = $this->getState('phonograms_keywords')	;
//		}
		return $this->_keywords;
	}

	 function get_where_clause_keywords($keywords){ //germi
//	 	$keywords = utf8_decode(trim($this->get_keywords($keywords)));
	 	$keywords = trim($this->get_keywords($keywords));


		$keyword=explode(" ",$keywords);
		$cadena="";
		for($i=0;$i<sizeof($keyword);$i++){
			$cadena.="((#__konsa_exp_phonograms.phonogram_title LIKE '%".$keyword[$i]."%') OR (#__konsa_exp_phonograms.text LIKE '%".$keyword[$i]."%') OR (#__konsa_exp_phonograms.comment LIKE '%".$keyword[$i]."%') OR (#__konsa_exp_expeditions.expedition_title LIKE '%".$keyword[$i]."%') OR (#__konsa_exp_towns.town_name LIKE '%".$keyword[$i]."%')) AND ";
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

	function _buildContentOrderBy()
	{
		$mainframe =& JFactory::getApplication();
		$option = JRequest::getCmd('option');
                $orderby = '';
                $filter_order     = $this->getState('filter_order');
                $filter_order_Dir = $this->getState('filter_order_Dir');
 
                /* Error handling is never a bad thing*/
                if(!empty($filter_order) && !empty($filter_order_Dir) ){
                        $orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
                }
        return $orderby;
	}



}
