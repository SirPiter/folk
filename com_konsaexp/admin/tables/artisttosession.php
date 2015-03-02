<?php

/**
 * @version		2.5.15
 * @package		konsaexp
 * @copyright	2015
 * @license		GPLv2
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


class TableArtisttosession extends JTable
{

	var $artist_id = null;
	var $session_name = null;       

	function TableArtisttosession(& $db) {
		parent::__construct('#__konsa_exp_artists_to_sessions', 'id', $db);
	}

	function check(){

		return true;
	}
}