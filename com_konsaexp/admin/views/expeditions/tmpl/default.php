<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="messages"></div>
<form action="<?php echo JRoute::_( 'index.php' );?>" method="post" name="adminForm" id="adminForm">
<div id="editcell">
                <table>
                        <tr>
					<td width="100%">
						<?php echo JText::_( 'COM_KONSAEXP_FILTER' ); ?>:
						<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" onchange="document.adminForm.submit();" /> <button onclick="this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_GO_SEARCH' ); ?></button> <button onclick="document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value='';this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_FILTER_RESET' ); ?></button>
                        </td>
                        <td nowrap="nowrap">
						<?php
						echo $this->lists['chief_collector'];
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
				<?php // echo JText::_( 'Expedition theme' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_EXPEDITION_TITLE', 'expedition_title', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Expedition Chief' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_EXPEDITION_CHIEF', 'chief_collector', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Year' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_EXPEDITION_YEAR', 'year_begin', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center" width="100">
				<?php echo JText::_( 'COM_KONSAEXP_ACTION' ); ?>
			</th>

		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
	//	print_r($row);//die();

		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=expedition&task=edit&cid[]='. $row->id );
		$link_collector = JRoute::_( 'index.php?option=com_konsaexp&controller=collector&task=edit&cid[]='. $row->chief_collector );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->expedition_title; ?></a>
			</td>
            <td align="center">
				<a href="<?php echo $link_collector ?>"><?php echo $row->collector_full_name; ?></a>
			</td>
            <td align="center">
				<?php echo $row->year_begin; ?>
			</td>
            <td align="center">
				<div id="module-menu1" class="table-menu">
			<ul id="menu" style="z-index:auto;">
<li class="node" style="border: none;"><a href="#">Добавить...</a><ul>
<li><a href="<?php echo JRoute::_( 'index.php?option=com_konsaexp&controller=phonogram&task=edit&cid[]=0&tpl=form_new&exp_id='. $row->id ); ?>" class="konsa-icon-16-phonogramms">Фонограмму</a></li>
<li class="separator"><span></span></li>
<li><a href="<?php echo JRoute::_( 'index.php?option=com_konsaexp&controller=document&task=edit&cid[]=0&exp_id='. $row->id ); ?>" class="konsa-icon-16-documents">Документ</a></li>
<li class="separator"><span></span></li>
<li><a href="index.php?option=com_config" class="konsa-icon-16-photos">Фото</a></li>
<li class="separator"><span></span></li>
</ul>
</div>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
    <tfoot>
    <tr>
      <td colspan="10"><?php  echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

	</table>
</div>

<input type="hidden" name="filter_order" value="<?php echo $this->lists['exp_order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['exp_order_Dir']; ?>" />
<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="expedition" />
</form>
