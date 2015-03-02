<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?
	if($this->params->get('showletternavigation')){
		echo MusColHelper::letter_navigation('');
	}
?>

<fieldset  class="searchexpeditions"> <legend  style="font-size:1.2em">Поиск экспедиции</legend>
<form action="index.php" method="get" title="Поиск экспедиции">
	<input type="text" id="searchword" name="searchword" size="72" maxlength="255" value="<? echo $this->searchword; ?>"/><br />
	<? echo JHTML::_('select.genericlist', $this->collectors, 'collectors_id', null, 'id', 'collector_full_name', $this->collector_id); ?>
	<? // echo JHTML::_('select.genericlist', $this->towns, 'towns_id', null, 'id', 'town_name', $this->town_id); ?>
    <input type="submit" value="<? echo JText::_('Search Expeditions'); ?>" />
<? if ($this->collector_id OR $this->searchword) { ?>
    <input type="submit" value="<? echo JText::_('All Expeditions'); ?>" onclick="javascript:document.getElementById('searchword').value='';document.getElementById('collectors_id').value='0';" />
    <? } ?>
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
<h1>Список экспедиций</h1>


     <table class="adminlist" width="100%">
     	<thead>
		<tr>
			<th>
				<?php // echo JText::_( 'Expedition theme' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Expedition theme', 'expedition_title', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Expedition Chief' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Expedition Chief', 'chief_collector', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Year' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Year', 'year_begin', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
		</tr>
	</thead>
<?php    
for ($i=0, $n=count( $this->expeditions ); $i < $n; $i++)	{
	$row = &$this->expeditions[$i];

	$link_exp= JRoute::_( 'index.php?option=com_konsaexp&view=expedition&id='. $row->id  );
	$link_call= JRoute::_( 'index.php?option=com_konsaexp&view=collector&id='. $row->chief_collector  );
	 ?>
    <tr>
	    <td  style='padding-left:5px;'>
		          <a class='llista_artista' style='width:100%;' href='<?php echo $link_exp; ?>' title="Подробное описание экспедиции">
					 <?php echo $row->expedition_title; ?></a>
         </td>
                              <td  style='padding-left:5px;'>
                     <a class='llista_artista' style='width:100%;' href='<?php echo $link_call; ?>'  title="Все экспедиции руководителя">
					 <?php echo $row->collector_full_name; ?>
                     </a>
                </td>
                <td align="center"><?php echo $row->year_begin; ?></td>

    </tr>

<?php
	 // end if
}      
?>
</table>

<div class="konsaexpfooter"><? echo KonsaExpHelper::showKonsaExpFooter(); ?></div>