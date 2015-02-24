<?php
/**
 * @package ats
 * @copyright Copyright (c)2011-2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

class AtsControllerJuser extends F0FController
{
	public function execute($task)
	{
		$task = 'browse';
		parent::execute($task);
	}

	protected function onBeforeBrowse()
	{
		require_once JPATH_ROOT.'/administrator/components/com_ats/helpers/ats.php';

		$cat = $this->input->getInt('category', 0);

		return AtsHelper::isManager($cat);
	}
}