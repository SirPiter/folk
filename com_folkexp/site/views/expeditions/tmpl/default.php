
<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
JHTML::_('behavior.modal','a.modal'); ?>

<?
	$itemid = $this->params->get('itemid');
	if($itemid != "") $itemid = "&Itemid=" . $itemid;
?>



<form action="index.php" method="get" title="<? echo JText::_('Expeditions list'); ?>" name="adminForm">

<h1>Список экспедиций</h1>
<table  align="left">
	<tr>
		<td width="100%">
		<?php echo JText::_( 'Search' ); ?>: 
		<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" size="40" maxlength="255" /> &nbsp;<button onclick="document.adminForm.limitstart.value=0; submitform();return false;"><?php echo JText::_( 'Search Expeditions' ); ?></button>

 <? if ($this->keywords) { ?>
    &nbsp;
<button onclick="document.getElementById('expedition_keys').value='';document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value=''; this.form.getElementById('expedition_keys').value='0';this.form.getElementById('expedition_keys').value='';document.adminForm.limitstart.value=0;this.form.submit();"><?php echo JText::_( 'All expeditions' ); ?></button>
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
                <?php echo JHTML::_( 'grid.sort', 'Expedition theme', 'expedition_title', $this->lists['exp_filter_order_Dir'], $this->lists['exp_filter_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Expedition Chief' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Expedition Chief', 'collector_full_name', $this->lists['exp_filter_order_Dir'], $this->lists['exp_filter_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Year' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Year', 'year_begin', $this->lists['exp_filter_order_Dir'], $this->lists['exp_filter_order']); ?>
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
	 // end for
}      
?>  
  <tfoot>
    <tr>
      <td colspan="3"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

</table>

	<input type="hidden" name="filter_order" value="<?php echo $this->lists['exp_filter_order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['exp_filter_order_Dir']; ?>" />
    <input type="hidden" name="option" value="com_konsaexp" />
    <input type="hidden" name="view" value="expeditions" />
    <input type="hidden" name="Itemid" value="<?php echo $this->params->get('itemid'); ?>" />
    <input type="hidden" name="expedition_keys"  id="expedition_keys" value=""/><br />
</form>

<div class="konsaexpfooter"><?  echo KonsaExpHelper::showKonsaExpFooter(); ?></div>
