<?php

/**
 * @version		2.5.0
 * @package		konsaexp
 * @copyright		2012
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class ExpeditionsModelArtist extends JModel
{

	function __construct()
	{
		parent::__construct();

//		$array = JRequest::getVar('cid',  0, '', 'array');
//		$this->setId((int)$array[0]);
		
		$id = JRequest::getVar('id');
		$this->setId((int)$id);
//		$artist_id = $this->expedition->chief_artist	;
	}


	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}


	function &getData()
	{
		
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT #__konsa_exp_artists.*, '.
					 ' #__konsa_exp_towns.town_name as name_place_of_birth, '.
					 ' towns1.town_name as name_place, '.
					 ' towns2.town_name as name_place_of_death '.
					 ' FROM #__konsa_exp_artists '.
					 ' LEFT OUTER JOIN #__konsa_exp_towns ON (#__konsa_exp_artists.place_of_birth = #__konsa_exp_towns.id) '.
					 ' LEFT OUTER JOIN #__konsa_exp_towns as towns1 ON (#__konsa_exp_artists.place = towns1.id) '.
					 ' LEFT OUTER JOIN #__konsa_exp_towns as towns2 ON (#__konsa_exp_artists.place_of_death = towns2.id) '.
					 ' WHERE  #__konsa_exp_artists.id = '.$this->_id;

			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

		}
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
		}
		return $this->_data;
	}
	
	
	
	function getExpeditionsData()
	{

	//echo 'exp'; die;
		if (empty( $this->_expeditions_data )){
			$query = 	' SELECT * FROM #__konsa_exp_expeditions '.
						' ORDER BY begin_date ';
						
						
			$query = 	' SELECT exp.* , coll.* FROM #__konsa_exp_expeditions as exp '.
						' INNER JOIN #__konsa_exp_artists as coll ON (exp.chief_artist = coll.id) '.
						' ORDER BY exp.begin_date '; 
						
			$query = 	' SELECT #__konsa_exp_expeditions.id, '.
						' #__konsa_exp_expeditions.expedition_title, '.
						' #__konsa_exp_expeditions.begin_date, '.
						' #__konsa_exp_expeditions.end_date, '.
						' #__konsa_exp_expeditions.chief_artist, '.
						' #__konsa_exp_expeditions.year_begin, '.
						' #__konsa_exp_artists.artist_name, '.
						' #__konsa_exp_artists.artist_lastname, '.
						' #__konsa_exp_artists.artist_full_name '.
						' FROM  #__konsa_exp_artists '.
						' INNER JOIN #__konsa_exp_expeditions  ON (#__konsa_exp_artists.id = #__konsa_exp_expeditions.chief_artist) '.
						' WHERE #__konsa_exp_expeditions.chief_artist = '.$this->_id;
						
						
			$this->_db->setQuery( $query );
			$this->_expeditions_data = $this->_db->loadObjectList();
			//print_r($query);
			//print_r($this->_expeditions_data); die;
			
		}
		return $this->_expeditions_data;
	}



}