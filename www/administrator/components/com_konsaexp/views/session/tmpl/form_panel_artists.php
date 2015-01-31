<?php
/**
 * @version     2.5.14
 * @package     com_konsaexp
 * @copyright   
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access'); 
?>

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
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_SESSION_ARTIST', 'artist_name', $this->lists['sessions_order_Dir'], $this->lists['sessions_order']); ?>

			</th>
     <th>
				<?php // echo JText::_( 'Town' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'COM_KONSAEXP_SESSION_ATRIST_TOWN', 'town_name', $this->lists['sessions_order_Dir'], $this->lists['sessions_order']); ?>
                
			</th>

		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=artist&task=edit&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->artist_full_name; ?></a>
			</td>
			<td align="center">
				<?php echo $row->town_name; ?>
			</td>

		</tr>
		<?php
		$k = 1 - $k;
		
	}
	?>
    <tfoot>
    <tr>
      <td colspan="6"><?php // echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

	</table>
</div>
