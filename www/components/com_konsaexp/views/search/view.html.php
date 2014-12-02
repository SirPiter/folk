<?php

/** 
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */
jimport( 'joomla.application.component.view');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'helpers.php');
	
class ExpeditionsViewSearch extends JView
{

	function display($tpl = null)
	{
		 $mainframe =& JFactory::getApplication();
		
		$pathway	= & $mainframe->getPathway();
		$document	= & JFactory::getDocument();
		
		$search = JRequest::getVar('search');
		
		$params = &JComponentHelper::getParams( 'com_konsaexp' );
		
		$artist_list		= & $this->get( 'ArtistList');
		$genre_list		= & $this->get( 'GenresData');
		$format_list		= & $this->get( 'FormatList');
		$genre_id		= & $this->get( 'GenreId');
		$searchword		= & $this->get( 'Searchword');


			
		switch($search){
			case "phonogramms":

				$songs		=  & $this->get( 'SongsData');
				$artist_id		= & $this->get( 'ArtistId');
				$pagination =& $this->get('Pagination');
				
				$params = &JComponentHelper::getParams( 'com_konsaexp' );
				
				//$plugins = JPluginHelper::getPlugin('muscolplayers');
				//$plugin = $plugins[0];
				// we use only one player, the first in the plugin item list
				//$plugin_ok = JPluginHelper::importPlugin('muscolplayers',$plugin->name); 
				
				$all_songs = array();
				
				$k = 0;
				
				for($i = 0, $n = count($songs); $i < $n; $i++){
					if( ($songs[$i]->filename != "" || $songs[$i]->video != "" ) && $plugin_ok){
						$songs[$i]->position_in_playlist = $k ;
						
						$songs[$i]->player = plgMuscolplayers::renderPlayer($songs[$i]);
						
						$all_songs[] = $songs[$i];
						$k++;
					}
				}
		
				if(!empty($all_songs)){
					// first parameter: array of songs. second parameter: true for multiple-songs-player
					$player = plgMuscolplayers::renderPlayer($all_songs, true, array(), JRoute::_('index.php?searchword='.$searchword.'&artist_id='.$artist_id.'&genre_id='.$genre_id.'&option=com_konsaexp&view=search&search=songs&format=feed&type=xspf') );
				}
				
				else $player = "";

				$this->assignRef('songs',		$songs);
				$this->assignRef('artist_id',		$artist_id);
				$this->assignRef('pagination', $pagination);
				$this->assignRef('player',		$player);
				
		
			break;
			
			case "expeditions":
			
				$expeditions	= & $this->get( 'ExpeditionsData');
				$collector_id	= & $this->get( 'CollectorId');
				$town_id		= & $this->get( 'TownId');

				$this->assignRef('expeditions',		$expeditions);
				$this->assignRef('collector_id',	$collector_id);
				$this->assignRef('town_id',	$town_id);
//				$this->assignRef('currency',		$params->get('currency'));
			
			break;
		}
		
		$this->assignRef('searchword',		$searchword);
//		$this->assignRef('format_list',		$format_list);
//		$this->assignRef('artist_list',		$artist_list);
		$this->assignRef('params',		$params);
//		$this->assignRef('genre_list',		$genre_list);
//		$this->assignRef('genre_id',		$genre_id);
		
		if($params->get('keywords') != ""){
			$document->setMetaData( 'keywords', $document->getMetaData( 'keywords' ) . ", " . $params->get('keywords') );
		}
		if($params->get('description') != ""){
			$document->setMetaData( 'description', $params->get('description') );
		}
	
		//creem els breadcrumbs
		
		$pathway->addItem(JText::_('Search'), 'index.php?option=com_konsaexp&view=search');
		
		//creem el titol
		
		$document->setTitle( JText::_('Search') );
		
		//cridem els CSS
		$document->addStyleSheet('components/com_konsaexp/assets/letter.css');
		$document->addStyleSheet('components/com_konsaexp/assets/artist_detailed.css');
		$document->addStyleSheet('components/com_konsaexp/assets/album.css');
		$document->addStyleSheet('components/com_konsaexp/assets/style.css');

		
		//mirem el layout
		$this->_layout	= & $this->get( 'Layout');
//		print_r($this->_layout); //die;
		
//		if($search == "phonogramms") $this->_layout = "phonogramms_view";

// Создание списка собирателей		
		$collectors_list = & $this->get('CollectorsList');
//		$this->assignRef('collectors_list',	$collectors_list);
	 	$collectors[] = JHTML::_('select.option',  '0', "All collectors", 'id', 'collector_full_name' );
	    // Добавляем массив данных из базы данных
    	$collectors = array_merge( $collectors, $collectors_list);
		$this->assignRef('collectors',	$collectors);
		
// Создание списка населенных пунктов
		$towns_list = & $this->get('TownsList');
	 	$towns[] = JHTML::_('select.option',  '0', "All towns", 'id', 'town_name' );
	    // Добавляем массив данных из базы данных
    	$towns = array_merge( $towns, $towns_list);
		$this->assignRef('towns',	$towns);


		parent::display($tpl);
	}
	
	
	
	
	function show_genre_tree($genres,$level){
				
		for($i = 0; $i < count($genres); $i++){
			$return .= $this->render_option($genres[$i]->id,$genres[$i]->genre_name,$level);
			$level ++;
			if(!empty($genres[$i]->sons)){
				$return .= 	$this->show_genre_tree($genres[$i]->sons,$level);
			}
			$level --;
		}
		//echo $return;
		return $return;
		
	}
	
	function render_option($id, $name, $level){
		$indent = "";
		
		for($i = 0; $i < $level; $i++){
			$indent .= "&nbsp;&nbsp;";	
		}
		
		$selected = ""; 
		if( $id == $this->genre_id ) $selected = "selected";
            
		return "<option value='".$id."' $selected >".$indent.$name."</option>";	
	}

}
?>
