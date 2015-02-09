<?php

/**
 * @version	2.5.0
 * @package	konsaexp
 * @copyright	2012
 * @license	GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class RegionsModelRegion extends JModel
{

	var $_regiontype_list = null;

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
			$query = ' SELECT * FROM #__konsa_exp_regions '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
		}
		return $this->_data;
	}

/*	function getRegionsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_towns_data )){
				$query = 	' SELECT id,format_name FROM #__konsa_exp_regions '.
							' WHERE display_group = 0 '.
						 	' ORDER BY order_num ';
				$this->_db->setQuery( $query );
				$this->_towns_data = $this->_db->loadObjectList();
			}
		return $this->_regions_data;
	}
*/

	function getRegionsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_regions_data )){
				$query = 	' SELECT * FROM #__konsa_exp_regions '.
						 	' ORDER BY id ';

				$this->_db->setQuery( $query );
				$this->_regions_data = $this->_db->loadObjectList();
			}

		return $this->_regions_data;
	}


	function store()
	{
		$row =& $this->getTable();
		//print_r($row);die();
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

	function saveorder(){

		$cids		= JRequest::getVar( 'order_id', array(0), 'post', 'array' );
		$order		= JRequest::getVar( 'order', array (0), 'post', 'array' );

		JArrayHelper::toInteger($cids, array(0));
		JArrayHelper::toInteger($order, array(0));

		$row =& $this->getTable();

		if (count( $cids )) {
			$i = 0;
			foreach($cids as $cid) {
				$row->id = $cid;
				$row->order_num = $order[$i];

				if (!$row->store( )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
				$i++;
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

	function getRegionTypeList()
	{
		if (empty( $this->_towntype_list )){
			$query = ' SELECT DISTINCT type '
			. ' FROM #__konsa_exp_regions '
			.' ORDER BY type '
			;
			$this->_db->setQuery( $query );
			$this->_towntype_list = $this->_db->loadAssocList();
		}

 	return $this->_regiontype_list;
	}

}
