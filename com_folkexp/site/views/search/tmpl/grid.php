<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

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
<form action="index.php" method="get">
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
</form>
</div>

<?php
for ($i=0, $n=count( $this->albums ); $i < $n; $i++)	{
	$row = &$this->albums[$i];
	if(count( $row->albums ) > 0){
		$image_attr = array(
							"title" => $row->format_name
							);
		$format_image = JHTML::image('images/formats/' . $row->icon , $row->format_name , $image_attr );
	?>
<div class="format_title"><?php echo $format_image; ?> <span><?php echo $row->format_name; ?></span></div>
        	
            <ul class="albums">
            <?php
			$itemid = $this->params->get('itemid');
			if($itemid != "") $itemid = "&Itemid=" . $itemid;
			
            for ($j=0, $m=count( $row->albums ); $j < $m; $j++)	{
                $album = $row->albums[$j];
                $link= JRoute::_( 'index.php?option=com_muscol&view=album&id='. $album->id .$itemid);
				$image = MusColHelper::createThumbnail($album->image, $album->name, $this->params->get('thumb_size_artist_2'), $image_attr);
?>
                
                <li>
                    <a href="<?php echo $link; ?>" class="<? echo strtolower($row->format_name); ?>">
                        <div class="<? echo strtolower($row->format_name); ?>">
                        <?php echo $image; ?>            
                        </div>
                        <span class="artist"><?php echo $album->artist_name; ?></span>
                        <span class="name"><?php echo $album->name; ?></span>
                        <span class="year"><?php echo $album->year." ".MusColHelper::show_stars($album->points,false,false,false,true); ?></span>
                    </a>
                </li>
        
            <?php
            }
            ?>
            </ul>
<?php
	} // end if
}
?>

<div align="center"><? echo MusColHelper::showMusColFooter(); ?></div>
