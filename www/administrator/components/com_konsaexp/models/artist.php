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

}