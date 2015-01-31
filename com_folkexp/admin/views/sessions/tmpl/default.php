<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="messages"></div>
<form action="<?php echo JRoute::_( 'index.php' );?>" method="post" name="adminForm" id="adminForm">

<?php // print_r($this->items); die; ?>
<div id="editcell">
                <table>
                        <tr>
					<td width="100%">
						<?php echo JText::_( 'COM_KONSAEXP_FILTER' ); ?>:
						<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" onchange="document.adminForm.submit();" /> <button onclick="this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_GO_SEARCH' ); ?></button> <button onclick="document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value='';this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_FILTER_RESET' ); ?></button>
                        </td>
                        <td nowrap="nowrap">
						<?php
//						echo $this->lists['chief_collector'];
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
				<?php // echo JText::_( 'Session code' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_SESSION_CODE', 'session_code', $this->lists['session_order_Dir'], $this->lists['session_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Session Theme' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_SESSION_TITLE', 'session_theme', $this->lists['session_order_Dir'], $this->lists['session_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Date' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_SESSION_DATE', 'date', $this->lists['session_order_Dir'], $this->lists['session_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Place' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_SESSION_PLACE', 'place', $this->lists['session_order_Dir'], $this->lists['session_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Expedition' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_SESSION_EXPEDITION', 'expedition', $this->lists['session_order_Dir'], $this->lists['session_order']); ?>
			</th>
			
		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
	//	print_r($row);//die();

		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=session&task=edit&cid[]='. $row->id );
		$link_expedition = JRoute::_( 'index.php?option=com_konsaexp&controller=expedition&task=edit&cid[]='. $row->expedition_id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->session_code; ?></a>
			</td>
            <td align="center">
				<a href="<?php echo $link; ?>"><?php echo $row->session_title; ?></a>
			</td>
            <td align="center">
				<?php echo $row->date; ?>
			</td>
            <td align="center">
				<?php echo $row->town_name; ?>
			</td>
			            <td align="center">
				<a href="<?php echo $link_expedition; ?>"><?php echo $row->expedition_title; ?></a>
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

<input type="hidden" name="filter_order" value="<?php echo $this->lists['session_order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['session_orderr_Dir']; ?>" />
<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="session" />
</form>
