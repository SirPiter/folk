<?php

/**
* @package plugin AdminExile
* @copyright (C) 2010-2011 RicheyWeb - www.richeyweb.com
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* AdminExile Copyright (c) 2011 Michael Richey.
* AdminExile is licensed under the http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
*
* AdminExile version 1.2 for Joomla 1.6.x devloped by RicheyWeb
*
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * AdminExile system plugin
 */
class plgSystemAdminExile extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemAdminExile( &$subject, $config )
	{
		parent::__construct( $subject, $config );
	}

	/* The generator tag isn't added until the document is rendered */
	function onAfterInitialise()
	{
		$app = JFactory::getApplication();
		// this plugin is meant for administrator
		if($app->isAdmin()) {           
                    // Once you're in - you're in
                    if(JFactory::getUser()->id) return true;
                    
                    // the admin access key is required to exist in the session variables or in the URL
                    $key = $this->params->get('key','adminexile');                    

                    // first we check the session variable
                    if($app->getUserState("plg_sys_adminexile.$key",false)) {
                            return true;
                    } else {
                            // no session set, check the URL
                            // first, we look for valid mail link request
                            if(array_key_exists('email',JRequest::get('GET'))) {
                                if($this->params->get('maillink',true) && count($this->params->get('maillinkgroup',array()))) {
                                    $this->_maillink(JRequest::getVar('email',false),$this->params->get('maillinkgroup',array()));
                                    $this->_redirect();
                                }
                            }
                            // second, we look for valid auth
                            if(array_key_exists($key,JRequest::get('GET'))) {
                                if($this->params->get('twofactor',false) && ($this->params->get('keyvalue',false) != JRequest::getVar($key))) {
                                    $this->_redirect();
                                } else {
                                    // found it, set the session and clear the key from the URL
                                    $app->setUserState("plg_sys_adminexile.$key",true);
                                    header("Location: ".JURI::root()."administrator");
                                    return true;
                                }
                            } else {
                                    // no session, no url - redirecting
                                $this->_redirect();
                            }
                    }
                } else {
                    if(
                            !$this->params->get('frontrestrict',0) || (
                                    JRequest::getCmd('option','') != 'com_users' &&
                                    JRequest::getVar('task','') != 'user.login'
                            )
                    ) return true;
                    $db = JFactory::getDbo();
                    $query=$db->getQuery(true);
                    $query->select('id')->from('#__users')->where('username='.$db->quote(JRequest::getVar('username','','POST')));
                    $db->setQuery($query);
                    $user = JFactory::getUser($db->loadResult());
                    $restrictgroup = $this->params->get('restrictgroup',array());
                    foreach($restrictgroup as $group) {
                        if(in_array($group,$user->groups)) {
                            // this will give a nice non-descript error
                            JRequest::setVar('password','');
                            return true;
                        }
                    }
                }
	}
        public function _maillink($username=false,$groups=array()) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('id')->from('#__users')->where('username='.$db->quote($username));
            $db->setQuery($query);
            $userid = $db->loadResult();
            if(is_numeric($userid)) {
                $user = JFactory::getUser($userid);  
                $authorized = false;
                foreach($user->groups as $group) {
                    if(in_array($group,$groups)) $authorized = true;
                }
                if($authorized) {
                    // now that we know we're sending an email, load the language
                    JFactory::getLanguage()->load('plg_system_adminexile',JPATH_ADMINISTRATOR);
                    
                    // building the /administrator URL
                    $url = parse_url(JURI::root());
                    $url['path'] = explode('/',preg_replace(array('/(^\/)/','/(\/$)/'),'',$url['path']));
                    $url['path'][]='administrator';
                    $url['path']='/'.implode('/',$url['path']).'/';
                    $key = urlencode($this->params->get('key','adminexile'));
                    if($this->params->get('twofactor',false)) {
                        $url['query']=http_build_query(array($key=>urlencode($this->params->get('keyvalue',false))));
                    } else {  
                        $url['query']=$key;
                    }
                    $url=http_build_url($url);
                    
                    // prepare and send the email
                    $config = JFactory::getConfig();
                    $mailer = JFactory::getMailer();
                    $mailer->setSender(array($config->get('config.mailfrom'),$config->get('config.fromname')));
                    $mailer->addRecipient($user->email);
                    $mailer->setSubject(JText::_('PLG_SYS_ADMINEXILE_EMAIL_SUBJECT'));
                    $mailer->setBody($url."\n\n".str_replace('{email}',$user->email,JText::_('PLG_SYS_ADMINEXILE_EMAIL_BODY')));
                    $send =& $mailer->Send();
                    if ( $send !== true ) {
                        error_log($send->message);
                    }
                }
            }
        }
        public function _redirect() {
            // this is a new stealth feature - prevent /administrator session cookie from being set
            $hasheaders = false;
            foreach (headers_list() as $header) {
                if($hasheaders) continue;
                if (preg_match('/Set-Cookie/', $header)) {
                    $hasheaders = true;
                }
            }        
            if($hasheaders) {
                $phpversion = explode('.', phpversion());
                if ($phpversion[1] >= 3) { // identify as php 5.3
                    header_remove('Set-Cookie');
                } else {
                    header('Set-Cookie:');
                }
            }
            
            $redirecturl = $this->params->get('redirect',JURI::root());
            switch($redirecturl) {
                case '{HOME}':
                    $redirecturl = JURI::root();
                    break;
                case '{404}':
                    header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
                    header("Status: 404 Not Found");
                    if(!$this->params->get('fourofour',false)) {
                        die($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
                    } else {
                        $find=array('{url}','{serversignature}');
                        $replace=array($_SERVER['REQUEST_URI'],$_SERVER["SERVER_SIGNATURE"]);
                        die(str_replace($find,$replace,$this->params->get('fourofour')));
                    }
                    break;
                default:
                    break;
            }
            if($redirecturl != '{404}') header("Location: ".$redirecturl);
            return true;
        }
}
if (!function_exists('http_build_url')) {
    define('HTTP_URL_REPLACE', 1);          // Replace every part of the first URL when there's one of the second URL
    define('HTTP_URL_JOIN_PATH', 2);        // Join relative paths
    define('HTTP_URL_JOIN_QUERY', 4);       // Join query strings
    define('HTTP_URL_STRIP_USER', 8);       // Strip any user authentication information
    define('HTTP_URL_STRIP_PASS', 16);      // Strip any password authentication information
    define('HTTP_URL_STRIP_AUTH', 32);      // Strip any authentication information
    define('HTTP_URL_STRIP_PORT', 64);      // Strip explicit port numbers
    define('HTTP_URL_STRIP_PATH', 128);     // Strip complete path
    define('HTTP_URL_STRIP_QUERY', 256);    // Strip query string
    define('HTTP_URL_STRIP_FRAGMENT', 512); // Strip any fragments (#identifier)
    define('HTTP_URL_STRIP_ALL', 1024);     // Strip anything but scheme and host
// Build an URL
// The parts of the second URL will be merged into the first according to the flags argument. 
// 
// @param  mixed      (Part(s) of) an URL in form of a string or associative array like parse_url() returns
// @param  mixed      Same as the first argument
// @param  int        A bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
// @param  array      If set, it will be filled with the parts of the composed url like parse_url() would return 
    function http_build_url($url, $parts = array(), $flags = HTTP_URL_REPLACE, &$new_url = false) {
        $keys = array('user', 'pass', 'port', 'path', 'query', 'fragment');

        // HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
        if ($flags & HTTP_URL_STRIP_ALL) {
            $flags |= HTTP_URL_STRIP_USER;
            $flags |= HTTP_URL_STRIP_PASS;
            $flags |= HTTP_URL_STRIP_PORT;
            $flags |= HTTP_URL_STRIP_PATH;
            $flags |= HTTP_URL_STRIP_QUERY;
            $flags |= HTTP_URL_STRIP_FRAGMENT;
        }
        // HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
        else if ($flags & HTTP_URL_STRIP_AUTH) {
            $flags |= HTTP_URL_STRIP_USER;
            $flags |= HTTP_URL_STRIP_PASS;
        }

        // Parse the original URL
        $parse_url = is_array($url)?$url:parse_url($url);

        // Scheme and Host are always replaced
        if (isset($parts['scheme']))
            $parse_url['scheme'] = $parts['scheme'];
        if (isset($parts['host']))
            $parse_url['host'] = $parts['host'];

        // (If applicable) Replace the original URL with it's new parts
        if ($flags & HTTP_URL_REPLACE) {
            foreach ($keys as $key) {
                if (isset($parts[$key]))
                    $parse_url[$key] = $parts[$key];
            }
        }
        else {
            // Join the original URL path with the new path
            if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH)) {
                if (isset($parse_url['path']))
                    $parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
                else
                    $parse_url['path'] = $parts['path'];
            }

            // Join the original query string with the new query string
            if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY)) {
                if (isset($parse_url['query']))
                    $parse_url['query'] .= '&' . $parts['query'];
                else
                    $parse_url['query'] = $parts['query'];
            }
        }

        // Strips all the applicable sections of the URL
        // Note: Scheme and Host are never stripped
        foreach ($keys as $key) {
            if ($flags & (int) constant('HTTP_URL_STRIP_' . strtoupper($key)))
                unset($parse_url[$key]);
        }


        $new_url = $parse_url;

        return
                ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
                . ((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') . '@' : '')
                . ((isset($parse_url['host'])) ? $parse_url['host'] : '')
                . ((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
                . ((isset($parse_url['path'])) ? $parse_url['path'] : '')
                . ((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
                . ((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
        ;
    }

}