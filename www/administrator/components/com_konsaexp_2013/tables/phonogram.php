<?php

/** 
 * @version		1.0.0
 * @package		konsa_expedition
 * @copyright	2010 SP
 * @license		GPLv2
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


class TablePhonogram extends JTable
{

	var $id = null;
	var $phonogram_title = null;
	var $collector_id = null;
	var $expedition_id = null;
	var $town_id = null;
	var $recorddate = null;
	var $soundfile = null;
	var $textfile = null;
	var $comment = null;
	var $text = null;


	function TablePhonogram(& $db) {
		parent::__construct('#__konsa_exp_phonograms', 'id', $db);
	}
	
	function check(){
		return true;
	}	

}