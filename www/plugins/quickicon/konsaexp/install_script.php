<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
class plgquickiconkonsaexpInstallerScript
{
	function install($parent) {
		$db = JFactory::getDbo();
		$db->setQuery('UPDATE #__extensions SET enabled = "1" WHERE name = "plg_quickicon_konsaexp"' );
		if (!$db->execute()) {
        		throw new Exception($db->getErrorMsg());
        	}
	}
 
}
