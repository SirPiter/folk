<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?
	$itemid = $this->params->get('itemid');
	if($itemid != "") $itemid = "&Itemid=" . $itemid;
?>

<? if($this->letter == "") { 
	echo $this->introtext; ?>      
<form action="index.php" method="get" title="Поиск">
<fieldset  class="searchexpeditions"> <legend  style="font-size:1.2em">Поиск собирателей</legend>
	<input type="text" name="searchword" id="searchword" size="73" maxlength="255" value="<? echo $this->searchword; ?>"/>
    &nbsp;&nbsp;<input type="submit" value="<? echo JText::_('Search'); ?>" />
    <? if ($this->searchword) { ?>
    &nbsp;&nbsp;<input type="submit" value="<? echo JText::_('All collectors'); ?>" onclick="javascript:document.getElementById('searchword').value='';" />
    <? } ?>

</fieldset>

<hr />
<h1><? echo JText::_('Collectors list'); ?></h1>

     <table class="adminlist" width="100%">
     	<thead>
		<tr>
			<th>
				<?php // echo JText::_( 'Expedition theme' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Collector fullname', 'collector fullname', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Expedition Chief' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Place of birth', 'place_of_birth', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Year' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Birth date', 'birth_date', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
		</tr>
	</thead>
<?php    
for ($i=0, $n=count( $this->collectors ); $i < $n; $i++)	{
	$row = &$this->collectors[$i];

//	$link_exp= JRoute::_( 'index.php?option=com_konsaexp&view=expedition&id='. $row->id  );
	$link_call= JRoute::_( 'index.php?option=com_konsaexp&view=collector&id='. $row->id  );
	 ?>
    <tr>
	    <td  style='padding-left:5px;'>
		          <a class='llista_artista' style='width:100%;' href='<?php echo $link_call; ?>' title="Полное имя">
					 <?php echo $row->collector_full_name; ?></a>
         </td>
                              <td  style='padding-left:5px;'>
                    					 <?php echo $row->name_place_of_birth; ?>
                </td>
                <td align="center"><?php echo $row->birth_date; ?></td>

    </tr>

<?php
	 // end if
}      
?>
</table>


<? } ?>

    <input type="hidden" name="option" value="com_konsaexp" />
    <input type="hidden" name="view" value="collectors" />
    <input type="hidden" name="Itemid" value="<?php echo $this->params->get('itemid'); ?>" />
</form>


<div class="konsaexpfooter"><?  echo KonsaExpHelper::showKonsaExpFooter(); ?></div>
