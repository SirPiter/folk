<?php

/**
 * @version		1.0.1
 * @package		konsa_expeditions
 * @copyright	2010 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class TracksModelTrack extends JModel
{
	 
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
		
	}

	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
//		$this->_artists_data	= null;	
//		$this->_genres_data	= null;	
		
	}

	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__konsa_exp_tracks '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		//print_r( $this->_data);die();
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
		}
		return $this->_data;
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
	
	function store()
	{	
		$row =& $this->getTable();

		$data = JRequest::get( 'post' );
		$data['lyrics'] = JRequest::getVar('lyrics', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$data['review'] = JRequest::getVar('review', '', 'post', 'string', JREQUEST_ALLOWRAW);
		
		$datafiles = JRequest::get( 'files' );
		
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
		else{ //retornem el id de l'album!
			return $data['expedition_id'];
		}
		//print_r($row);die();
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

}