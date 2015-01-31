<?php
/**
 * @copyright	Copyright (C) 2010 Michael Richey. All rights reserved.
 * @license		GNU General Public License version 3; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldJavascript extends JFormField
{
	protected $type = 'Javascript';

	protected function getInput()
	{
                $options = array('strings'=>array('messages'=>array(),'chars'=>array()));
                foreach(array('INVALIDASCII','INVALIDCHAR','NOTNUMERIC') as $string){
                    $options['strings']['messages'][$string]=JText::_('PLG_SYS_ADMINEXILE_MESSAGE_'.$string);
                }
                $chars = array('DOLLAR','AMPERSAND','PLUS','COMMA','FORWARDSLASH','COLON','SEMICOLON','EQUALS','QUESTION','AT','SPACE','QUOTE','LESSTHAN','GREATERTHAN','POUND','PERCENT','LEFTCURLY','RIGHTCURLY','PIPE','BACKSLASH','CARAT','TILDE','LEFTBRACKET','RIGHTBRACKET','GRAVE');
                foreach($chars as $string){
                    $options['strings']['chars'][$string]=JText::_('PLG_SYS_ADMINEXILE_CHAR_'.$string);
                }
                jimport('joomla.version');
                $version = new JVersion;
                $shortversion = explode('.',$version->getShortVersion());
                $options['version']=$shortversion[0].'.'.$shortversion[1];
                JHtml::_('behavior.framework',true);
		$doc = &JFactory::getDocument();
                $doc->addScriptDeclaration("\n".'window.plg_sys_adminexile_config = '.json_encode($options).';'."\n");
                $doc->addScript(JURI::root(true).'/media/plg_system_adminexile/admin.js');
		return;
	}
}
