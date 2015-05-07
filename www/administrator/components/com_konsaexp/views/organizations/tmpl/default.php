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
						//echo $this->lists['letter'];
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
				&#160;
			</th>
			<th>
				<?php // echo JText::_( 'organization' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_ORGANIZATION_NAME', 'name', $this->lists['organizations_order_Dir'], $this->lists['organizations_order']); ?>
			</th>
	      	<th>
				<?php // echo JText::_( 'Birth date' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_ORGANIZATION_CODE', 'code', $this->lists['organizations_order_Dir'], $this->lists['organizations_order']); ?>
			</th>
    		<th>
				<?php echo JText::_( 'COM_KONSAEXP_ORGANIZATION_DEFAULT' ); ?>
			</th>
		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=organization&task=edit&cid[]='. $row->id );
		$fullname = $row->name;
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<input id="cb0" type="radio" title="1" onclick="Joomla.isChecked(this.checked);" value=<?php echo $row->id; ?> name="cid">
			</td>
			<td>
				<?php echo JHTML::_('link', $link, $fullname, array('class'=>'art-link')); ?>
			</td>
      <td align="center">
				<?php echo JHTML::_('link', $link, $row->code, array('class'=>'art-link')); ?>
      	</td>
		<td align="center">
			<?php echo JHtml::_('jgrid.isdefault', $row->default, $i, FALSE);?>
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

<input type="hidden" name="filter_order" value="<?php echo $this->lists['organizations_order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['organizations_order_Dir']; ?>" />
<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="organization" />
</form>
