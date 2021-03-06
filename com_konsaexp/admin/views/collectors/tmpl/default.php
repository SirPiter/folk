<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
 		<table>
              <tr>
					<td width="100%">
						<?php echo JText::_( 'COM_KONSAEXP_FILTER' ); ?>:
						<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" onchange="document.adminForm.submit();" /> <button onclick="this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_GO_SEARCH' ); ?></button>
<button onclick="document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value='';this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_FILTER_RESET' ); ?></button>
                        </td>

                        <td nowrap="nowrap">
						<?php
						echo $this->lists['letter'];
						?>
					</td>
               </tr>
           </table>

	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'COM_KONSAEXP_ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th>
				<?php // echo JText::_( 'Collector' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_COLLECTOR', 'collector_name', $this->lists['collectors_order_Dir'], $this->lists['collectors_order']); ?>

			</th>
      <th>
				<?php // echo JText::_( 'Birth date' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_BIRTH_DATE', 'birth_date', $this->lists['collectors_order_Dir'], $this->lists['collectors_order']); ?>

			</th>
      <th>
				<?php // echo JText::_( 'Town' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_TOWN', 'town_name', $this->lists['collectors_order_Dir'], $this->lists['collectors_order']); ?>
                
			</th>
      <th>
				<?php echo JText::_( 'COM_KONSAEXP_LETTER' ); ?>
			</th>

		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=collector&task=edit&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->collector_full_name; ?></a>
			</td>
      <td align="center">
				<?php echo $row->birth_date; ?>
			</td>
			<td align="center">
				<?php echo $row->town_name; ?>
			</td>
      <td align="center">
				<?php echo $row->letter; ?>
			</td>

		</tr>
		<?php
		$k = 1 - $k;
		
	}
	?>
    <tfoot>
    <tr>
      <td colspan="6"><?php  echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

	</table>
</div>

<input type="hidden" name="filter_order" value="<?php echo $this->lists['collectors_order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['collectors_order_Dir']; ?>" />
<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="collector" />
</form>
