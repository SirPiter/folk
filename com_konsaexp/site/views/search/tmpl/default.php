<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?
	if($this->params->get('showletternavigation')){
		echo MusColHelper::letter_navigation('');
	}
?>


<fieldset  class="searchexpeditions"> <legend  style="font-size:1.2em">Поиск экспедиции</legend>
<form action="index.php" method="get" title="Поиск экспедиции">
	<input type="text" name="searchword" size="70" maxlength="255" value="<? echo $this->searchword; ?>"/><br />
	<? echo JHTML::_('select.genericlist', $this->collectors, 'collectors_id', null, 'collector_id', 'collector_full_name', 0); ?>
	<? echo JHTML::_('select.genericlist', $this->towns, 'towns_id', null, 'town_id', 'town_name', 0); ?>
    <input type="submit" value="<? echo JText::_('Search Expeditions'); ?>" />
    <input type="hidden" name="option" value="com_konsaexp" />
    <input type="hidden" name="search" value="expeditions" />
    <input type="hidden" name="view" value="search" />
    <input type="hidden" name="Itemid" value="<?php echo $this->params->get('itemid'); ?>" />
</form>
</fieldset>

<fieldset  class="searchsongs"> <legend  style="font-size:1.2em">Поиск фонограмм</legend>
<form action="index.php" method="get" name="PhonSearchForm">
    <input type="text" name="phonogram_keys" id="phonogram_keys" size="73" maxlength="255" value="<? echo $this->phonogram_keys; ?>"/><br />
	<? echo JHTML::_('select.genericlist', $this->collectors, 'collectors_id', null, 'id', 'collector_full_name', 0); ?>
	<? echo JHTML::_('select.genericlist', $this->towns, 'towns_id', null, 'id', 'town_name', $this->town_id); ?>
    &nbsp;&nbsp;<input type="submit" value="<? echo JText::_('Search Phonogramms'); ?>"  style="width:130px;" onclick="document.adminForm.limitstart.value=0;"/>

    <input type="hidden" name="option" value="com_konsaexp" />
    <input type="hidden" name="search" value="phonograms" />
    <input type="hidden" name="view" value="phonograms" />
    <input type="hidden" name="Itemid" value="<?php echo $this->params->get('itemid'); ?>" />
</form>
</fieldset>
<hr />

<?php
for ($i=0, $n=count( $this->expeditions ); $i < $n; $i++)	{
	$row = &$this->expeditions[$i];
	if(count( $row->expeditions ) > 0){
		$image_attr = array(
							"title" => $row->format_name
							);
		$format_image = JHTML::image('images/formats/' . $row->icon , $row->format_name , $image_attr );
	?>
    <div class="format_title"><?php echo $format_image; ?> <span><?php echo $row->format_name; ?></span></div>

            <?php
			$image_attr = array(
								"class" => "image_40_llista"
								);
			$itemid = $this->params->get('itemid');
			if($itemid != "") $itemid = "&Itemid=" . $itemid;
			
            for ($j=0, $m=count( $row->albums ); $j < $m; $j++)	{
                $album = $row->albums[$j];
				
                $link= JRoute::_( 'index.php?option=com_muscol&view=album&id='. $album->id . $itemid );
				$image = MusColHelper::createThumbnail($album->image, $album->name, $this->params->get('thumb_size_artist_1'), $image_attr);
				
?>

                    <div class="data">
                    <a class='llista_artista' style='width:630px;' href='<?php echo $link; ?>'>
                        <table border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td><?php echo $image; ?> </td>
                                <td style='padding-left:5px;'><?php echo $album->name; ?>
                                    <div class='year_llista'>
                                    <?php echo $album->year." ".MusColHelper::show_stars($album->points,false,false,false,true); ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </a>
                    </div>
        
            <?php
            }
            ?>
            <br />
<?php
	} // end if
}
?>

<div align="center"><? echo KonsaExpHelper::showKonsaExpFooter(); ?></div>