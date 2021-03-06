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

class ArtistsModelArtist extends JModel
{

	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	function setId($id)
	{
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__konsa_exp_artists '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

			$this->_data->related = explode(",",$this->_data->related);
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
		}

		return $this->_data;
	}

	function getArtistsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_artists_data )){
				$query = ' SELECT id,collector_name FROM #__konsa_exp_artists '.
						' WHERE id != '.$this->_id.
						 ' ORDER BY letter,class_name';
				$this->_db->setQuery( $query );
				$this->_artists_data = $this->_db->loadObjectList();
			}

		return $this->_artists_data;

	}

	function store()
	{
		$row =& $this->getTable();
		
		$data = JRequest::get( 'post' );
		$data['review'] = JRequest::getVar('review', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$datafiles = JRequest::get( 'files' );

//		print_r($data); die;
		
		// Bind the form fields to the album table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->bind($datafiles)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the hello record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}
		//print_r($data);
// Сохранение списков		
		foreach($data as $key => $value){
				
			//print_r($value);		
		
			if(substr($key,0,8) == "session_")	{
				$session_id = (int)substr($key,6);
				$session_data = array(
						"artist_id" => $data[id] ,
						"session_id" => $value
				);
				//die;
				$this->save_session($session_data);
			} //les can�ons NOVES
			else if(substr($key,0,10) == "0_session_")	{
				$session_id = (int)substr($key,8);
				$session_data = array(
						"artist_id" => $data[id] ,
						"session_id" => $value
				);
				if($value != "" && $data[id] != "") // nomes guardem si hi ha nom...
//					print_r($session_data); die;
					$this->save_session($session_data);
			}
		}
		//die;
		return true;
	}


	function save_session($data)
	{
		$row =& $this->getTable('Artisttosession');
		$mainframe =& JFactory::getApplication();
		//print_r($row); die;
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if (!$row->store()) {
			//print_r($row); $mainframe->close();
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}
		return true;
	}
	
	
	function delete_session()
	{
	
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$sessionid = JRequest::getVar( 'sessionid', int);//, 'post', 'array' );
		
	//print_r($session_id);
		$row =& $this->getTable('Artisttosession');
	
		if($sessionid>0) {
			//print_r("Session:".$session_id); die;
			if (!$row->delete( $sessionid )) {
				$this->setError( $row->getErrorMsg() );
				return false;
			}		
		} else if (count( $cids )) {
		//	print_r($cids); die;
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}
	
	
	
	function delete()
	{
		
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids )) {
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}

 	function getTownsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_towns_data )){
				$query = ' SELECT id,town_name FROM #__konsa_exp_towns '.
								 ' ORDER BY town_name';
				$this->_db->setQuery( $query );
				$this->_towns_data = $this->_db->loadObjectList();
			}

		return $this->_towns_data;

	}

	function getLinkedSessions()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_linkedsessions )){
			$query = 'SELECT S.*,  A2S.* FROM #__konsa_exp_artists_to_sessions as A2S'.
				' LEFT JOIN #__konsa_exp_sessions as S ON S.id = A2S.session_id '.
				' WHERE artist_id='.$this->_id;
			$this->_db->setQuery( $query );
			$this->_linkedsessions = $this->_db->loadObjectList();
			//print_r($this->_linkedsessions); die;
		}
		
		return $this->_linkedsessions;
	}

	function getSessionsList()
	{
		if (empty( $this->_sessions_list )){
			$query = ' SELECT id,session_title FROM #__konsa_exp_sessions '.
					' ORDER BY session_title';
			$this->_db->setQuery( $query );
			$this->_sessions_list = $this->_db->loadAssocList();
		}
		return $this->_sessions_list;
	}

	
	
	
}