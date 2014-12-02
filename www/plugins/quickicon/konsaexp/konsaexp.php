<?php
/**
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Joomla! udpate notification plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	Quickicon.Joomla
 * @since		2.5
 */
class plgQuickiconKonsaexp extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 *
	 * @since       2.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Returns an icon definition for an icon which looks for extensions updates
	 * via AJAX and displays a notification when such updates are found.
	 *
	 * @param  $context  The calling context
	 *
	 * @return array A list of icon definition associative arrays, consisting of the
	 *				 keys link, image, text and access.
	 *
	 * @since       2.5
	 */
	public function onGetIcons($context)
	{
		if ($context != $this->params->get('context', 'mod_quickicon')) {
			return;
		}

		return array(array(
			'link' => 'index.php?option=com_konsaexp',
			'image' => 'com_konsaexp/konsaexp_48.png',
			'text' => JText::_('PLG_QUICKICON_KONSAEXP'),
			'id' => 'plg_quickicon_konsaexp'
		));
	}
}
