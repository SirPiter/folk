<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$user = JFactory::getUser(); ?>

<?
	if($this->params->get('showletternavigation')){
		echo MusColHelper::letter_navigation('');
	}
?>

<div class="searchalbums">
<form action="index.php" method="get">
    <input type="text" name="searchword" size="32" maxlength="255" value="<? echo $this->searchword; ?>"/>
    <select name="format_id">
    	<option value=""><? echo JText::_('All formats'); ?></option>
        <? foreach($this->format_list as $format){ 
			if($format->id == $this->format_id) $selected = "selected"; else $selected = ""; ?>
        	<option value="<? echo $format->id; ?>" <? echo $selected; ?>><? echo $format->format_name; ?></option>
        <? } ?>
    </select>
    <select name="genre_id" id="genre_id">
    	<option value=''><? echo JText::_("All genres"); ?></option>
		<?php echo $this->show_genre_tree($this->genre_list,0); ?>
    </select>
    <input type="submit" value="<? echo JText::_('Search albums'); ?>" />

    <input type="hidden" name="option" value="com_muscol" />
    <input type="hidden" name="search" value="albums" />
    <input type="hidden" name="view" value="search" />
    <input type="hidden" name="Itemid" value="<?php echo $this->params->get('itemid'); ?>" />
</form>
</div>

<div class="searchsongs">
<form action="index.php" method="get" name="adminForm">
    <input type="text" name="searchword" size="13" maxlength="255" value="<? echo $this->searchword; ?>"/>
    <select name="artist_id">
    	<option value=""><? echo JText::_('All artists'); ?></option>
        <? foreach($this->artist_list as $artist){ 
			if($artist->id == $this->artist_id) $selected = "selected"; else $selected = ""; ?>
        	<option value="<? echo $artist->id; ?>" <? echo $selected; ?>><? echo $artist->artist_name; ?></option>
        <? } ?>
    </select>
    <select name="genre_id" id="genre_id">
    	<option value=''><? echo JText::_("All genres"); ?></option>
		<?php echo $this->show_genre_tree($this->genre_list,0); ?>
    </select>
    <input type="submit" value="<? echo JText::_('Search songs'); ?>" />
    
    <input type="hidden" name="option" value="com_muscol" />
    <input type="hidden" name="search" value="songs" />
    <input type="hidden" name="view" value="search" />
    <input type="hidden" name="Itemid" value="<?php echo $this->params->get('itemid'); ?>" />

</div>
<div class="pagination">
<? echo JText::_('Display') . " ". $this->pagination->getLimitBox(); ?>
<? echo $this->pagination->getResultsCounter(); ?></div>
</form>
<? if( ( $user->id && $this->params->get('displayplayer') ) || $this->params->get('displayplayer') == 2 ){ ?>
<div class="player" align="center"><? echo $this->player; ?></div>
<? } ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="sectiontableheader" align="right" width="5%">#</td>
        <td class="sectiontableheader" width="50%"><? echo JText::_('Song'); ?></td>
        <td class="sectiontableheader"  width="40%"><? echo JText::_('Album'); ?></td>
        <td class="sectiontableheader" align="right" ></td>
        <td class="sectiontableheader" align="right" width="5%"></td>
    </tr>
    <? $k = 1; 
	$itemid = $this->params->get('itemid');
	if($itemid != "") $itemid = "&Itemid=" . $itemid;
	for ($i = 0, $n=count( $this->songs ); $i < $n; $i++)	{ 
	
		$link_song = JRoute::_('index.php?option=com_muscol&view=song&id='. $this->songs[$i]->id . $itemid);
		$link_album = JRoute::_('index.php?option=com_muscol&view=album&id='. $this->songs[$i]->album_id . $itemid);
		$file_link = MusColHelper::create_file_link($this->songs[$i]); ?>
	<tr class="sectiontableentry<? echo $k; ?>" >
        <td align="right"><? echo ($i + 1); ?></td>
        <td><a href="<? echo $link_song; ?>"><? echo $this->songs[$i]->name; ?></a></td>
        <td><a href="<? echo $link_album; ?>"><? echo $this->songs[$i]->album_name; ?></a></td>
        <td><?  if( ($user->id && $this->params->get('displayplayer')) || $this->params->get('displayplayer') == 2 ){ echo $this->songs[$i]->player; } ?></td>
        <td>
		
		<? if($this->songs[$i]->filename != "" && $this->params->get('allowsongdownload')){ 
				if( $user->id  || $this->params->get('allowsongdownload') == 2 ){ ?>
            <a href="<? echo $file_link; ?>" title="<? echo JText::_('Download this song'); ?>"><? echo JHTML::image('components/com_muscol/assets/images/music.png','File'); ?></a>
            <? } 
			else  echo JHTML::image('components/com_muscol/assets/images/music.png','File',array("title" => JText::_("File available for registered users"))); 
             } ?> 
             <?php if($this->params->get('allowsongbuy') && $this->songs[$i]->buy_link != ""){ ?><a href="<?php echo $this->songs[$i]->buy_link; ?>" title="<?php echo JText::_('Buy this song'); ?>" target="_blank"><?php echo JHTML::image('components/com_muscol/assets/images/buy.png','Buy'); ?></a><?php } ?>
             </td>
	</tr>
    <? $k = 3 - $k; } ?>

</table>

<div align="center"><? echo MusColHelper::showMusColFooter(); ?></div>

