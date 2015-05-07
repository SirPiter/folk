<?php

/**
 * @version	2.5.28
 * @package	konsaexp
 * @copyright	2015
 * @license	GPLv2
 */

// No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


class TableOrganization extends JTable
{

	var $id = null;
	var $name = null;          // имя
	var $code = null;          // код
	var $comment = null;       // комментарий
	var $created = null;       // дата добавления
	var $created_by = null;    // кто добавил (id)
	var $modified = null;      // дата изменения
	var $modified_by = null;   // кто изменил (id)

	function TableOrganization(& $db) {
		parent::__construct('#__konsa_exp_organizations', 'id', $db);
	}

	function check(){

		if($this->id == 0){
			$this->created =  date('Y-m-d H:i:s') ;
		}

		return true;
	}



	function erase_multiple_whitespaces($cadena){
		$cadena2 = str_replace("  "," ",$cadena,$times);
		if($times!=0) $cadena2 = $this->erase_multiple_whitespaces($cadena2);
		return $cadena2;
	}


}