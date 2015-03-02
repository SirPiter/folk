<?php

/** 
 * @version		2.5.0
 * @package		konsaexp
 * @copyright	2012
 * @license		GPLv2
 */

jimport( 'joomla.application.component.view');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'helpers.php');
//require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.'logger.1simport.php');


class ExpeditionsViewArtists extends JView
{
	function display($tpl = null)
	{
		$mainframe =& JFactory::getApplication();
		
		$pathway	= & $mainframe->getPathway();
		$document	= & JFactory::getDocument();
		$uri 		= & JFactory::getURI();
		
		$model =& $this->getModel();
		
		$params = &JComponentHelper::getParams( 'com_konsaexp' );
		
		$this->_layout = $params->get('expedition_view');
		if($this->_layout == "") $this->_layout = "default";

		$items		= & $this->get( 'Data');
		$letter		= & $this->get( 'Letter');
		$format_list		= & $this->get( 'FormatList');
		$genre_list		= & $this->get( 'GenresData');
		$artist_list		= & $this->get( 'ArtistList');

		//echo "artists_list : ";
		//print_r($artists_list); // die;

		$pagination =& $this->get('Pagination');

		$this->assignRef('items',		$items);
		$this->assignRef('letter',		$letter);
		$this->assignRef('params',		$params);
		$this->assignRef('town_list',		$town_list);
		$this->assignRef('artist_list',		$artist_list);
		
		$this->assignRef('pagination', $pagination);
		
		$this->assign('action', 	$uri->toString());
		
		$searchword		= & $this->get( 'Searchword');
		$this->assignRef('searchword',		$searchword);
		
		$artists	= & $this->get( 'ArtistsData');
		$this->assignRef('artists',		$artists);
		
		$keywords		= & $this->get( 'Keywords');
		$pagination =& $this->get('Pagination');
		$this->assignRef('keywords',		$keywords);
		$this->assignRef('artist_list',		$artist_list);
		
		$this->assignRef('pagination', $pagination);


		
		$document->addScript('components/com_konsaexp/assets/functions.js');
		/*
		 * Подготовка списков
		 */
		$state =& $this->get( 'state' );
 
        /* Get the values from the state object that were inserted in the model's construct function */
        $lists['col_filter_order_Dir'] = $state->get( 'col_filter_order_Dir' );
        $lists['col_filter_order']     = $state->get( 'col_filter_order' );
 		$this->assignRef('lists', $lists);

		

// Создание списка населенных пунктов
		$towns_list = & $this->get('TownsList');
	 	$towns[] = JHTML::_('select.option',  '0', JText::_('All towns'), 'id', 'town_name' );
	    // Добавляем массив данных из базы данных
    	$towns = array_merge( $towns, $towns_list);
		$this->assignRef('towns',	$towns);
	
		//print_r($towns); // die;
		/*
		 * Process the prepare content plugins
		 */
		
		$intro->text = $params->get('introtext');
		$intro->text = str_replace("\n", '<br />', $intro->text); 
		$intro2->text = $params->get('introtext2');
		$intro2->text = str_replace("\n", '<br />', $intro2->text); 
		
		if($params->get('processcontentplugins')){
		
			$dispatcher	=& JDispatcher::getInstance();
			$plug_params = new JParameter('');
			
			JPluginHelper::importPlugin('content');
			$results = $dispatcher->trigger('onPrepareContent', array (& $intro, & $plug_params, 0));
			$results = $dispatcher->trigger('onPrepareContent', array (& $intro2, & $plug_params, 0));
		}
		
		$this->assignRef('introtext',		$intro->text);
		$this->assignRef('introtext2',		$intro2->text);
		
	//	if($params->get('keywords') != ""){
	//		$document->setMetaData( 'keywords', $document->getMetaData( 'keywords' ) . ", " . $params->get('keywords') );
	//	}
		if($params->get('description') != ""){
			$document->setMetaData( 'description', $params->get('description') );
		}
		
		//creem els breadcrumbs
		
		$pathway->addItem($letter, 'index.php?option=com_muscol&view=artists&letter='.$letter);
		
		//cridem els CSS
		$document->addStyleSheet('components/com_konsaexp/assets/letter.css');
		$document->addStyleSheet('components/com_konsaexp/assets/artists.css');
		$document->addStyleSheet('components/com_konsaexp/assets/style.css');
				
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
