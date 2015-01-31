<?php

/**
 * @version		1.0.1
 * @package		muscol
 * @copyright	2009 JoomlaMusicSolutions.com
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
 
class TracksViewTrack extends JView
{

//	var $genres_array = null;
	
	function display($tpl = null)
	{
		//get the album
		$track		=& $this->get('Data');
		$towns		=& $this->get('TownsList');
		
		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');
		
		$isNew		= ($track->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Track' ).': <small><small>[ ' . $text.' ]</small></small>','type' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		//print_r($towns);die();
		// push data into the template
		$this->assignRef('track',		$track);
		$this->assignRef('towns',		$towns);

		//$this->assignRef('genres',		$genres);

		parent::display($tpl);
	}


//////////////////////
// ненужные функции //
//////////////////////

	function show_genre_tree($genres,$level){
		
		$return = "";
		
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
		if( $id == $this->song->genre_id ) $selected = "selected";
            
		return "<option value='".$id."' $selected >".$indent.$name."</option>";	
	}
}