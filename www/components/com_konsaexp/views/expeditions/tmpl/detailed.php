<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php
	if($this->params->get('showletternavigation')){
		echo MusColHelper::letter_navigation($this->letter);
	}
	$itemid = $this->params->get('itemid');
	if($itemid != "") $itemid = "&Itemid=" . $itemid;
?>

<? if($this->params->get('showpdficon')){ ?>
<div class="icons">
<? 
$attr = array("title" => "PDF");
$link_pdf = JRoute::_('index.php?option=com_muscol&view=artists&format=ownpdf&letter=' . $this->letter);
$pdf_icon = JHTML::image('components/com_muscol/assets/images/page_white_acrobat.png',"PDF", array("title" => "PDF"));
?>
<a href="<? echo $link_pdf; ?>" target="_blank"><? echo $pdf_icon; ?></a>
</div>
<? } ?>

<? if($this->letter == "") {
	echo $this->introtext; ?>

<? if($this->params->get('showalbumsearch')){ ?>
<div class="searchalbums">
<form action="index.php" method="get">
    <input type="text" name="searchword" size="32" maxlength="255" value="<? echo $this->searchword; ?>"/>
    <select name="format_id">
    	<option value=""><? echo JText::_('All formats'); ?></option>
        <? foreach($this->format_list as $format){ ?>
        	<option value="<? echo $format->id; ?>" ><? echo $format->format_name; ?></option>
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
<? } ?>

<? if($this->params->get('showsongsearch')){ ?>
<div class="searchsongs">
<form action="index.php" method="get">
    <input type="text" name="searchword" size="13" maxlength="255" value="<? echo $this->searchword; ?>"/>
    <select name="artist_id">
    	<option value=""><? echo JText::_('All artists'); ?></option>
        <? foreach($this->artist_list as $artist){ ?>
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
<? }

echo $this->introtext2;

} ?>

<?php

if($this->params->get('showartistshome') || $this->letter != ""){

	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$this->artist = &$this->items[$i];
		echo $this->loadTemplate('artist');
	} 
	?>
	
	<?php if($this->params->get('usepaginationartists')){ ?>
	<div align="center">
	<form action="<?php echo $this->action; ?>" method="post" name="adminForm">
	<?php echo JText::_('Display') . " ". $this->pagination->getLimitBox() . "<br />" .  $this->pagination->getPagesLinks() ; ?>
	</form>
	</div>
	<?php } ?>

<?php } ?>

<div align="center"><? echo MusColHelper::showMusColFooter(); ?></div>
