<?php

/**
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class TableTown extends JTable
{
	var $id = null;
	var $town_name = null;
	var $coordinata = null;
	var $oldname = null;
	var $rename_year = null;
	var $type = null;
	var $region = null;
	var $subname = null;
	var $comment = null;

	function TableTown(& $db) {
		parent::__construct('#__konsa_exp_towns', 'id', $db);
	}
	
	function check(){
		return true;
	}
}
