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
                        </tr>
                    </table>




	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'COM_KONSAEXP_ID' ); ?>
			</th>
			<th width="20">
            	<?php 
				$counter = 0;
				for ($i=0, $n=count( $this->items ); $i < $n; $i++){ 
							if($this->items[$i]->num_albums == 0) $counter++;
				}
				?>
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $counter; ?>);" />
			</th>			
			<th>
				<?php echo JText::_( 'COM_KONSAEXP_PHONOGRAM_TITLE' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'COM_KONSAEXP_EXPEDITION' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'COM_KONSAEXP_RECORD_DATE' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'COM_KONSAEXP_RECORD_PLACE' ); ?>
			</th>
            <th width="50">
				<?php echo JText::_( 'COM_KONSAEXP_PLAY' ); ?>
			</th>
            
		</tr>
	</thead>

	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ),$check_i = 0; $i < $n; $i++)	{
		$row = &$this->items[$i];
		
		if($row->num_albums) $checked 	= "";
		else {
			$checked 	= JHTML::_('grid.id',   $check_i, $row->id );
			$check_i++;
		}
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=phonogram&task=edit&parent_controller=phonograms&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td <?php if($row->display_group) echo "style='padding-left:50px;'" ?>>
				<a href="<?php echo $link; ?>"><?php echo $row->phonogram_title; ?></a>
			</td>
             <td>
			<? 	for ($j=0, $p=count( $this->expeditions );$j < $p; $j++)	{
					if($row->expedition_id == $this->expeditions[$j]->id) echo $this->expeditions[$j]->expedition_title;
				} 	?>
            <td>
				<?php echo $row->recorddate; ?>
			</td> 
             <td>
			<?  for ($j=0, $p=count( $this->towns );$j < $p; $j++)	{
					if($row->town_id == $this->towns[$j]->id) echo $this->towns[$j]->town_name;
				} 	?>
			</td> 
            <td>
	<!--			<div id="audioplayer_<?php //echo $row->id; ?>">Для отображения плеера необходим Flash и javascript</div>  
        		<script type="text/javascript">  
				AudioPlayer.embed("audioplayer_<?php //echo $row->id; ?>", {soundFile: "http://music.sirpiter.ru/<?php // echo $row->soundfile; ?>"});  
				</script> 
-->
			</td> 

		</tr>
		<?php
		$k = 1 - $k;
	}
	?>

    <tfoot>
    <tr>
      <td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

	</table>
</div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="phonogram" />
</form>
