<?php
/**
  *
 * @version 2.5.14
 * @package konsaexp
 * @subpackage mod_expmenu
 * @copyright KonsaExp Team - All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * http://folklab.ru
 */

// no direct access
defined('_JEXEC') or die;


abstract class ModExpMenuHelper {


	public static function getExpComponent($authCheck = true) {

		$lang	= JFactory::getLanguage();
		$user		= JFactory::getUser();

		$db = JFactory::getDBO();
		$q = 'SELECT m.id, m.title, m.alias, m.link, m.parent_id, m.img, e.element FROM `#__menu` as m
				LEFT JOIN #__extensions AS e ON m.component_id = e.extension_id
		         WHERE m.client_id = 1 AND e.enabled = 1 AND m.id > 1 AND e.element = \'com_virtuemart\'
		         AND (m.parent_id=1 OR m.parent_id =
			                        (SELECT m.id FROM `#__menu` as m
									LEFT JOIN #__extensions AS e ON m.component_id = e.extension_id
			                        WHERE m.parent_id=1 AND m.client_id = 1 AND e.enabled = 1 AND m.id > 1 AND e.element = \'com_virtuemart\'))
		         ORDER BY m.lft';

		$db->setQuery($q);

		$vmComponentItems = $db->loadObjectList();
		$result = new stdClass();
		if ($vmComponentItems) {
			if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
			VmConfig::loadJLang('com_virtuemart.sys');
			// Parse the list of extensions.
			foreach ($vmComponentItems as &$vmComponentItem) {
				$vmComponentItem->link = trim($vmComponentItem->link);
				$vmComponentItem->link =JFilterOutput::ampReplace($vmComponentItem->link);
				if ($vmComponentItem->parent_id == 1) {
					if ($authCheck == false || ($authCheck && $user->authorise('core.manage', $vmComponentItem->element))) {
						$result = $vmComponentItem;
						if (!isset($result->submenu)) {
							$result->submenu = array();
						}

						if (empty($vmComponentItem->link)) {
							$vmComponentItem->link = 'index.php?option=' . $vmComponentItem->element;
						}

						$vmComponentItem->text = $lang->hasKey($vmComponentItem->title) ? JText::_($vmComponentItem->title) : $vmComponentItem->alias;
					}
				} else {
					// Sub-menu level.
					if (isset($result)) {
						// Add the submenu link if it is defined.
						if (isset($result->submenu) && !empty($vmComponentItem->link)) {
							$vmComponentItem->text = $lang->hasKey($vmComponentItem->title) ? JText::_($vmComponentItem->title) : $vmComponentItem->alias;

							$class = preg_replace('#\.[^.]*$#', '', basename($vmComponentItem->img));
							$class = preg_replace('#\.\.[^A-Za-z0-9\.\_\- ]#', '', $class);
							$vmComponentItem->class="icon-16-".$class;
							$result->submenu[] = & $vmComponentItem;
						}
					}
				}
			}

			return $result;
		} else {
			return NULL;
		}


	}

}
