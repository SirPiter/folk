<?php

/** 
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */
jimport( 'joomla.application.component.view');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'xspf.php');
	
class ArtistsViewSearch extends JView
{

	function display($tpl = null)
	{
		$mainframe =& JFactory::getApplication();
	
		$document =& JFactory::getDocument();
	
		$songs		= & $this->get( 'SongsData');
		
		$uri =& JFactory::getURI();
		$comp_params = &JComponentHelper::getParams( 'com_muscol' );
		$dirname = $comp_params->get('songspath');
		if(substr($dirname, 0, 1) == "/") $dirname = substr($dirname, 1);
		if(substr($dirname, -1) != "/") $dirname = $dirname . "/";
		
		$plugins = JPluginHelper::getPlugin('muscolplayers');
		//we take the first plugin in the list
		$plugin = JPluginHelper::getPlugin('muscolplayers',$plugins[0]->name);
		
		$params = new JParameter( $plugin->params );
		
		$base_path = $params->get('songsserver');
		
		if($base_path == "") $base_path = $uri->base() ;
		
		if(substr($base_path, -1) != "/") $base_path = $base_path . "/";
		
		$song_base = $base_path . $dirname ;
	
		foreach ( $songs as $song )
		{
			if($song->filename != ""){
				
				if(!strpos($song->filename,"://")) $song_path_complet = $song_base . $song->filename ;
				else $song_path_complet = $song->filename ;
								
				// load individual item creator class
				$item = new JFeedItem();
				$item->title 		= $song->name;
				$item->creator 		= $song->artist_name;
				$item->location 	= $song_path_complet;
				$item->duration 		= $song->length;
				if($song->image && $comp_params->get('loadimagesplayer')) $item->image 		= $uri->base() . "images/albums/" . $song->image;
				$item->annotation 		= $song->artist_name . " - " . $song->album_name;
				
				// loads item info into rss array
				$document->addItem( $item );
			}
		}
		
		$document->_styleSheets = array();
		
		
	}
	
	

}
?>
