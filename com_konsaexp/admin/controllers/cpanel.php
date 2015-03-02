<?php
/**
 * @version		2.5.14
 * @package		konsaexp
 * @copyright	2014 sirpiter.ru
 * @license		GPLv2
 **/
defined ( '_JEXEC' ) or die ();

/**
 *  Cpanel Controller
 *
 * @since 2.0
 */
class ExpeditionsControllerCpanel extends CpanelController {
	protected $baseurl = null;

	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_konsaexp';
	}
}
