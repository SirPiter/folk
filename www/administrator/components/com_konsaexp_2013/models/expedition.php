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

class ExpeditionsModelExpedition extends JModel
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
/*		$this->_artists_data	= null;
		$this->_formats_data	= null;
		$this->_genres_data	= null;
		$this->_tags_data	= null;
		$this->_types_data	= null;
*/
	}

	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__konsa_exp_expeditions '.
					'  WHERE id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

			if($this->_data){
				//$this->_data->genres = explode(",",$this->_data->genres);
		//		$this->_data->tags = explode(",",$this->_data->tags);
		//		$this->_data->types = explode(",",$this->_data->types);

				$time = $this->time_to_array($this->_data->length);
				$this->_data->hours = $time["hours"];
				$this->_data->minuts = $time["minuts"];
				$this->_data->seconds = $time["seconds"];
			}
		}
		// print_r( $this->_data);  //die();
		if (!$this->_data) {
			$this->_data = new stdClass();
			$this->_data->id = 0;
		}
		return $this->_data;
	}

function getCollectorsList()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_collectors_list )){
				$query = ' SELECT id,collector_name, collector_full_name FROM #__konsa_exp_collectors '.
						 ' ORDER BY letter';
				$this->_db->setQuery( $query );
				$this->_collectors_list = $this->_db->loadObjectList();
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

	function getExtendedTownsList()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_townswithregions )){
				$query = ' SELECT #__konsa_exp_towns.id, #__konsa_exp_towns.town_name, #__konsa_exp_regions.region_name '.
				'FROM #__konsa_exp_towns LEFT OUTER JOIN #__konsa_exp_regions ON (#__konsa_exp_towns.region = #__konsa_exp_regions.id) '.
				'ORDER BY #__konsa_exp_regions.region_name, #__konsa_exp_towns.town_name';
				$this->_db->setQuery( $query );
				$this->_townswithregions = $this->_db->loadObjectList();
			}
		return $this->_townswithregions;
	}

/////////////////////////////////////////////
	function store()
	{
		$row =& $this->getTable();
		//print_r($row);die();

		$data = JRequest::get( 'post' );
		$data['comment'] = JRequest::getVar('comment', '', 'post', 'string', JREQUEST_ALLOWRAW);

//print_r($data);

		$datafiles = JRequest::get( 'files' );
//print_r($datafiles);die();
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
//print_r($row);die();
		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->_db->getErrorMsg() );
			return false;
		}

//print_r($row); die;
		foreach($data as $key => $value){
			
//print_r($key);		//die;	

			if(substr($key,0,6) == "place_")	{
				$track_id = (int)substr($key,6);
				$track_data = array(
								   "id" => $track_id ,
								   "number" => $data["number_" . $track_id],
								   "town_id" => $value
								   );
				$this->save_track($track_data);
			} //les cançons NOVES
			else if(substr($key,0,8) == "0_place_")	{
				$track_id = (int)substr($key,8);
				$track_data = array(
								   "id" => 0 ,
								   "expedition_id" => $data["id"],
								   "number" => $data["0_number_" . $track_id],
								   "town_id" => $value	,
								   );
				//print_r($track_data); die;
				if($value != "") // nomes guardem si hi ha nom...
				$this->save_track($track_data);
			}
			else if(substr($key,0,16) == "phonogram_title_")	{
				$phonogram_id = (int)substr($key,16);
				$phonogram_data = array(
								   "id" => $phonogram_id ,
								   "phonogram_title" => $value
								   );
				$this->save_phonogram($phonogram_data);
			} //les cançons NOVES
			else if(substr($key,0,18) == "0_phonogram_title_")	{
				$phonogram_id = (int)substr($key,18);
				$phonogram_data = array(
								   "id" => 0 ,
								   "expedition_id" => $data["id"],
								   "phonogram_title" => $value	,
								   );
				//print_r($track_data); die;
				if($value != "") // nomes guardem si hi ha nom...
				$this->save_phonogram($phonogram_data);
			}
			else if(substr($key,0,12) == "0_doc_title_")	{
				$doc_id = (int)substr($key,12);
				$doc_data = array(
								   "id" => 0 ,
								   "expedition_id" => $data["id"],
								   "title" => $value	,
								   );
				//print_r($track_data); die;
				if($value != "") // nomes guardem si hi ha nom...
				$this->save_doc($doc_data);
			}

		}

		return true;
	}


	function getTracks(){
			if (empty( $this->tracks )){
				$query = 	' SELECT * FROM #__konsa_exp_tracks '.
							' WHERE expedition_id = ' . $this->_id .
						 	' ORDER BY number, date ';
				$this->_db->setQuery( $query );
				$this->tracks = $this->_db->loadObjectList();
			}
			//print_r($this->tracks);die();
		return $this->tracks;
	}

	function save_track($data)
	{
		$row =& $this->getTable('track');
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

	function getPhonograms(){
			if (empty( $this->phonograms )){
				$query = 	' SELECT * FROM #__konsa_exp_phonograms '.
							' WHERE expedition_id = ' . $this->_id .
						 	' ORDER BY phonogram_title ';
				$this->_db->setQuery( $query );
				$this->phonograms = $this->_db->loadObjectList();
			}
			//print_r($this->phonograms);die();
		return $this->phonograms;
	}

///////////////////////////
	function getDocs(){
			if (empty( $this->docs )){
				$query = 	' SELECT * FROM #__konsa_exp_documents '.
							' WHERE expedition_id = ' . $this->_id .
						 	' ORDER BY title ';
				$this->_db->setQuery( $query );
				$this->docs = $this->_db->loadObjectList();
			}
			//print_r($this->phonograms);die();
		return $this->docs;
	}


	function save_phonogram($data)
	{
		$row =& $this->getTable('phonogram');
		global $mainframe;
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

	function save_doc($data)
	{
		$row =& $this->getTable('document');
		global $mainframe;
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



















function getArtistsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_artists_data )){
				$query = ' SELECT id,artist_name FROM #__konsa_exp_artists '.
						 ' ORDER BY letter,class_name';
				$this->_db->setQuery( $query );
				$this->_artists_data = $this->_db->loadObjectList();
			}

		return $this->_artists_data;

	}

	function getAlbumsData(){

			if (empty( $this->albums_data )){
				$query = 	' SELECT al.id,al.name,ar.artist_name,f.format_name FROM #__konsa_exp_albums as al '.
							' LEFT JOIN #__konsa_exp_artists as ar ON ar.id = al.artist_id ' .
							' LEFT JOIN #__konsa_exp_format as f ON f.id = al.format_id ' .
							' WHERE al.id != ' . $this->_id .
						 	' ORDER BY ar.letter,ar.class_name,f.order_num,al.year,al.month';
				$this->_db->setQuery( $query );
				$this->albums_data = $this->_db->loadObjectList();
			}
			//print_r($this->albums_data);die();
		return $this->albums_data;

	}

	function getFormatsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_formats_data )){
				$query = ' SELECT id,format_name FROM #__konsa_exp_format '.
						 ' ORDER BY order_num';
				$this->_db->setQuery( $query );
				$this->_formats_data = $this->_db->loadObjectList();
			}

		return $this->_formats_data;

	}
	function getTypesData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_types_data )){
				$query = ' SELECT id,type_name FROM #__konsa_exp_type '.
						 ' ORDER BY id';
				$this->_db->setQuery( $query );
				$this->_types_data = $this->_db->loadObjectList();
			}

		return $this->_types_data;

	}
	function getSongs(){

			if (empty( $this->songs )){
				$query = 	' SELECT * FROM #__konsa_exp_songs '.
							' WHERE album_id = ' . $this->_id .
						 	' ORDER BY disc_num, num ';
				$this->_db->setQuery( $query );
				$this->songs = $this->_db->loadObjectList();

				if(!empty($this->songs)){
					for($i = 0, $n = count($this->songs); $i < $n; $i++){
						$time = $this->time_to_array($this->songs[$i]->length);
						$this->songs[$i]->hours = $time["hours"];
						$this->songs[$i]->minuts = $time["minuts"];
						$this->songs[$i]->seconds = $time["seconds"];
					}
				}
			}
			//print_r($this->songs);die();
		return $this->songs;

	}

	function time_to_array($total_time){

	  $segons = $total_time % 60;

	  $minuts = ($total_time - $segons)/60;

	  if($minuts >= 60){
	  $minuts_60 = $minuts % 60;
	  $hores = ($minuts - $minuts_60)/60;
	  }
	  else {
		  $hores=0;
		  $minuts_60 = $minuts;
	  }

	  $return["hours"] = $hores;
	  $return["minuts"] = $minuts_60;
	  $return["seconds"] = $segons;

	  return $return;
	}

	function getGenresData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_genres_data )){
				$query = ' SELECT * FROM #__konsa_exp_genres '.
						 ' WHERE parents = "0" '
						 ;
				$this->_db->setQuery( $query );
				$this->_genres_data = $this->_db->loadObjectList();

				for($i = 0; $i < count( $this->_genres_data ) ; $i++){
					$this->_genres_data[$i]->sons = $this->get_descendants($this->_genres_data[$i]);
				}
			}

		return $this->_genres_data;

	}

	function get_descendants($genre){

		$query = 	' SELECT * FROM #__konsa_exp_genres '.
					' WHERE '.
					' ( parents LIKE "%,'.$genre->id.',%"'.
							' OR parents LIKE "'.$genre->id.',%" '.
							' OR parents LIKE "%,'.$genre->id.'" '.
							' OR parents LIKE "'.$genre->id.'" ) '
					;
		$this->_db->setQuery( $query );
		$return = $this->_db->loadObjectList();

		if(!empty( $return )){
			for($i = 0; $i < count( $return ) ; $i++){
				$return[$i]->sons = $this->get_descendants($return[$i]);
			}

		}

		return $return;

	}

	function getTagsData()
		{
			// Lets load the data if it doesn't already exist
			if (empty( $this->_tags_data )){
				$query = ' SELECT * FROM #__konsa_exp_tags '.
						 ' ORDER BY id';
				$this->_db->setQuery( $query );
				$this->_tags_data = $this->_db->loadObjectList();
			}

		return $this->_tags_data;

	}


	function store__()
	{
		$row =& $this->getTable();
		//print_r($row);die();

		$data = JRequest::get( 'post' );
		$data['review'] = JRequest::getVar('review', '', 'post', 'string', JREQUEST_ALLOWRAW);

		$datafiles = JRequest::get( 'files' );

/*		if($data["show_separately"] == "on") $data["show_separately"] = "N";
		else $data["show_separately"] = "Y";
*/		
		//print_r($data);die();

		// Bind the form fields to the album table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->bind($datafiles)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}
		//print_r($row);die();

		//les cançons
		foreach($data as $key => $value){
			if(substr($key,0,5) == "song_")	{
				$song_id = (int)substr($key,5);
				$song_data = array(
								   "id" => $song_id ,
								   "disc_num" => $data["disc_num_" . $song_id],
								   "num" => $data["num_" . $song_id],
								   "hours" => $data["hours_" . $song_id],
								   "minuts" => $data["minuts_" . $song_id],
								   "seconds" => $data["seconds_" . $song_id],
								   "name" => $value
								   );
				$this->save_song($song_data);
			} //les cançons NOVES
			else if(substr($key,0,7) == "0_song_")	{
				$song_id = (int)substr($key,7);
				$song_data = array(
								   "id" => 0 ,
								   "album_id" => $data["id"],
								   "disc_num" => $data["0_disc_num_" . $song_id],
								   "num" => $data["0_num_" . $song_id],
								   "hours" => $data["0_hours_" . $song_id],
								   "minuts" => $data["0_minuts_" . $song_id],
								   "seconds" => $data["0_seconds_" . $song_id],
								   "name" => $value	,
								   "artist_id" => $data["artist_id"]
								   );
				if($value != "") // nomes guardem si hi ha nom...
				$this->save_song($song_data);
			}
		}

		return true;
	}

	function save_song($data)
	{
		$row =& $this->getTable('song');
		global $mainframe;

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

	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids )) {
			foreach($cids as $cid) {
				$query = ' DELETE FROM #__konsa_exp_songs WHERE album_id = ' . $cid ;
				$this->_db->setQuery($query) ;
				$this->_db->query();

				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}

}