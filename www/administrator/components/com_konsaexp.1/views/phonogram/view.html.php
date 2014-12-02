<?php

/**
 * @version		1.0.0
 * @package		konsa_expeditions
 * @copyright	2010 SP
 * @license		GPLv2
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
 
class PhonogramsViewPhonogram extends JView
{

//	var $genres_array = null;
	
	function display($tpl = null)
	{
		//получаем информацию из бызы


		$phonogram	=& $this->get('Data');
		$towns		=& $this->get('TownsList');  //должны быть только города, через которые проходила экспедиция
		$collectors	=& $this->get('CollectorsList');
		$expedition	=& $this->get('Expedition');
		$townswithregions	=& $this->get('ExtendedTownsList');

		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');
		
		$isNew		= ($phonogram->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Phonogram' ).': <small><small>[ ' . $text.' ]</small></small>','type' );
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
		$this->assignRef('phonogram',	$phonogram);
		$this->assignRef('towns',		$towns);
		$this->assignRef('collectors',	$collectors);
		$this->assignRef('expedition',	$expedition);
		$this->assignRef('townswithregions',	$townswithregions);

		
		//$document->addScript('components/com_konsaexp/assets/s5_mp3_player.js');
		$document->addScript('components/com_konsaexp/assets/audio-player/swfobject/swfobject.js');
		$document->addScript('components/com_konsaexp/assets/audio-player/audio-player.js');
		$document->addScript('components/com_konsaexp/assets/audio-player/player.js'); 

		
		
		parent::display($tpl);
	}


//////////////////////
// íåíóæíûå ôóíêöèè //
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
