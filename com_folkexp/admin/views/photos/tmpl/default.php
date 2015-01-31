<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
<div id="konsaexp" class="admin override">
           <div id="filter-bar" class="btn-toolbar">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" onchange="document.adminForm.submit();"  style="width: 300px;"/> <button onclick="this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_GO_SEARCH' ); ?></button>
				<button onclick="document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value='';this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_FILTER_RESET' ); ?></button>
    		</div>

	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th>
				<?php // echo JText::_( 'Collector' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_PHOTO_TITLE', 'title', $this->lists['photos_order_Dir'], $this->lists['photos_order']); ?>

			</th>
      <th>
				<?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_PHOTO_SHORT_DESCRIPTION', 'short_description', $this->lists['photos_order_Dir'], $this->lists['photos_order']); ?>

			</th>
            <th>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_PHOTO_DATE', 'doc_date', $this->lists['photos_order_Dir'], $this->lists['photos_order']); ?>
			</th>
            <th>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_PHOTO_ADD_DATE', 'add_date', $this->lists['photos_order_Dir'], $this->lists['photos_order']); ?>
			</th>
            <th>
				<?php echo JText::_( 'COM_KONSAEXP_PHOTO_IMAGE' ); ?>
			</th>


		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=photo&task=edit&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->title; ?></a>
			</td>
      <td align="center">
				<?php echo $row->short_description; ?>
			</td>
      <td align="center">
				<?php echo $row->doc_date; ?>
			</td>
      <td align="center">
				<?php echo $row->add_date; ?>
			</td>
      <td align="center">
				<?php echo $row->doc_image; ?>
			</td>

		</tr>
		<?php
		$k = 1 - $k;
		
	}
	?>
    <tfoot>
    <tr>
      <td colspan="8"><?php  echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

	</table>
</div>

<input type="hidden" name="filter_order" value="<?php echo $this->lists['photos_order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['photos_order_Dir']; ?>" />
<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="photo" />
</form>
