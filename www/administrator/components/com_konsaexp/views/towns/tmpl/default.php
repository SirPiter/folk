<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="<?php echo JRoute::_( 'index.php' );?>" method="post" name="adminForm">
<div id="editcell">

                <table>
                        <tr>
					<td width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" onchange="document.adminForm.submit();" /> <button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button> <button onclick="document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value='';this.form.submit();"><?php echo JText::_( 'Filter Reset' ); ?></button>
                        </td>
                        
                        <td nowrap="nowrap">
						<?php
						echo $this->lists['region'];
						?>
					</td>
                        </tr>
                    </table>

	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
            	<?php 
//				$counter = 0;
//				for ($i=0, $n=count( $this->items ); $i < $n; $i++){ 
//							if($this->items[$i]->num_albums == 0) $counter++;
//				}
				?>
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $counter; ?>);" />
			</th>			
			<th>
				<?php // echo JText::_( 'Town name' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Town name', 'town_name', $this->lists['towns_order_Dir'], $this->lists['towns_order']); ?>
			</th>
            <th>
				<?php echo JText::_( 'Type' ); ?>
			</th>
            <th>
				<?php  //echo JText::_( 'Region' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Region', 'region', $this->lists['towns_order_Dir'], $this->lists['towns_order']); ?>
			</th>
            <th>
				<?php echo JText::_( 'Comment' ); ?>
			</th>
            
		</tr>
	</thead>

	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ),$check_i = 0; $i < $n; $i++)	{
		$row = &$this->items[$i];

//		if($row->num_albums) $checked 	= "";
//		else {
			$checked 	= JHTML::_('grid.id',   $i, $row->id );
//			$check_i++;
//			}
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=town&task=edit&cid[]='. $row->id );

		
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td <?php // if($row->display_group) echo "style='padding-left:50px;'" ?>>
				<a href="<?php echo $link; ?>"><?php echo $row->town_name; ?></a>
			</td>
            <td>
				<?php echo $row->type; ?>
			</td> 
             <td>
				<?  //php echo $row->region; 
			for ($j=0, $p=count( $this->regions );$j < $p; $j++)	{
			if($row->region == $this->regions[$j]["id"]) echo $this->regions[$j]["region_name"];
			}
			
		?>

			</td> 
            <td>
				<?php echo $row->comment; ?>
			</td> 

		</tr>
		<?php
		$k = 1 - $k;
	}
	?>

    <tfoot>
    <tr>
      <td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

	</table>
</div>

<input type="hidden" name="filter_order" value="<?php echo $this->lists['towns_order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['towns_order_Dir']; ?>" />
<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="town" />
</form>
