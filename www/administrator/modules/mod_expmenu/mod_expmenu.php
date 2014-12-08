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

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
/* if (!class_exists( 'expConfig' )) {
	$path = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_konsaexp'.DS.'helpers'.DS.'config.php';
	if(file_exists($path)){
		require($path);
	} else {
		$app = JFactory::getApplication();
		$app->enqueueMessage('VirtueMart Administration module is still installed, please install VirtueMart again, or uninstall the module via the joomla extension manager');
		return false;
	}
}
*/

// Include the module helper classes.
if (!class_exists('ModExpMenuHelper')) {
	require dirname(__FILE__).'/helper.php';
}


// Initialise variables.
$lang		= JFactory::getLanguage();
$user		= JFactory::getUser();
$hideMainmenu	= JRequest::getInt('hidemainmenu')  ;

// Render the module layout
require JModuleHelper::getLayoutPath('mod_expmenu', $params->get('layout', 'default'));
