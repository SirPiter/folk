<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?
	$itemid = $this->params->get('itemid');
	if($itemid != "") $itemid = "&Itemid=" . $itemid;
?>

<form action="index.php" method="get" title="<? echo JText::_('Collectors list'); ?>" name="adminForm">

<h1><? echo JText::_('Collectors list'); ?></h1>
<table  align="left">
	<tr>
		<td width="100%">
		<?php echo JText::_( 'Search' ); ?>: 
		<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" size="40" maxlength="255" /> &nbsp;<button onclick="document.adminForm.limitstart.value=0; submitform();return false;"><?php echo JText::_( 'Search Collectors' ); ?></button>

 <? if ($this->keywords) { ?>
    &nbsp;
<button onclick="document.getElementById('collector_keys').value='';document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value=''; this.form.getElementById('collector_keys').value='0';this.form.getElementById('collector_keys').value='';document.adminForm.limitstart.value=0;this.form.submit();"><?php echo JText::_( 'All Collectors' ); ?></button>
    <? } ?>
    <hr />
		</td>
	</tr>
</table>

     <table class="adminlist" width="100%">
     	<thead>
		<tr>
			<th>
				<?php // echo JText::_( 'Expedition theme' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Collector fullname', 'collector_full_name', $this->lists['col_filter_order_Dir'], $this->lists['col_filter_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Expedition Chief' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Place of birth', 'place_of_birth', $this->lists['col_filter_order_Dir'], $this->lists['col_filter_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Year' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Birth date', 'birth_date', $this->lists['col_filter_order_Dir'], $this->lists['col_filter_order']); ?>
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
	 // end for
}      
?>
</table>


	<input type="hidden" name="filter_order" value="<?php echo $this->lists['col_filter_order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['col_filter_order_Dir']; ?>" />
    <input type="hidden" name="collector_keys"  id="collector_keys" value=""/><br />
    <input type="hidden" name="option" value="com_konsaexp" />
    <input type="hidden" name="view" value="collectors" />
    <input type="hidden" name="Itemid" value="<?php echo $this->params->get('itemid'); ?>" />
</form>


<div class="konsaexpfooter"><?  echo KonsaExpHelper::showKonsaExpFooter(); ?></div>
