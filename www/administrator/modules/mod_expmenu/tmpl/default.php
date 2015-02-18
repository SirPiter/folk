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

// No direct access.
defined('_JEXEC') or die;


$show_expmenu 	= $params->get('show_expmenu', 1);
$expMenu="";
$user = JFactory::getUser();
$lang = JFactory::getLanguage();
if ($show_expmenu) {
	$hideMainmenu=false;
}

// Get the authorised components and sub-menus.

/* SirPiter
$expComponentItems = ModExpMenuHelper::getExpComponent(true);

// Check if there are any components, otherwise, don't render the menu
if ($vmComponentItems) {
	$class = '';
	if ($hideMainmenu) {
		$class = "disabled";
	}
	$vmMenu='<ul id="menu" >';
	$vmMenu.='<li class="node '.$class.'"><a href="'.$vmComponentItems->link.'">'.$vmComponentItems->text.'</a>';

	if (!$hideMainmenu) {
		if (!empty($vmComponentItems->submenu)) {
			$vmMenu.='<ul>';
			foreach ($vmComponentItems->submenu as $sub) {
				$vmMenu.='<li><a class="'.$sub->class.'" href="'.$sub->link.'">'.$sub->text.'</a></li>';
			}
			$vmMenu.='</ul>';
		}
	}
	$vmMenu.='</li></ul>';
}

SirPiter */


$expMenu='<ul id="menu"  style="float: left;">';
$expMenu.='<li class="node exp"><a href="?option=com_konsaexp">'."Архив фонограмм".'</a>';
	$expMenu.='<ul>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=expeditions">'."Экспедиции".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=collectors">'."Собиратели".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=sessions">'."Сессии записи".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=phonograms">'."Фонограммы".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=artists">'."Исполнители".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=documents">'."Документы".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=photos">'."Фотографии".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=expeditions">'."Нотные расшифровки".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=towns">'."Населенные пункты".'</a></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp&controller=regions">'."Регионы".'</a></li>';
	$expMenu.='<li class="separator"><span></span></li>';
	$expMenu.='<li><a class="submenu" href="?option=com_konsaexp">'."Параметры архва".'</a></li>';
	$expMenu.='</ul>';
$expMenu.='</li></ul>';

echo $expMenu;