<?php

/** 
 * @version		1.5.0
 * @package		muscol
 * @copyright	2009 JoomlaMusicSolutions.com
 * @license		GPLv2
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


class TableTrack extends JTable
{

	var $id = null;
	var $town_id = null;
	var $expedition_id = null;
	var $village_name = null;
	var $number = null;
	var $date = null;
	
	function TableTrack(& $db) {
		parent::__construct('#__konsa_exp_tracks', 'id', $db);
	}
	
	function check(){
		return true;
	}	

}