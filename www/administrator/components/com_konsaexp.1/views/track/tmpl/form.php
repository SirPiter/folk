<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>
		<?php //print_r($this); die; ?>
		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="ID">
					<?php echo JText::_( 'ID' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->track->id;?>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="Expedition ID">
					<?php echo JText::_( 'Expedition ID' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->track->expedition_id;?>
			</td>
		</tr>
        <tr>
			<td width="100" align="right" class="key">
				<label for="artist">
					<?php echo JText::_( 'Town' ); ?>:
				</label>
			</td>
			<td><?php //print_r ($this->song); ?>
            <select name="town_id" id="town_id">
            <?php
			for ($i=0, $n=count( $this->towns );$i < $n; $i++)	{
			$row = &$this->towns[$i];
			$selected = ""; 
			if($row->id == $this->track->town_id) {
				$selected = "selected"; 
				$village_name = $row->town_name;
			} ?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->town_name;?></option>
            <?php } ?>
			</select>
            <input type="hidden" name="village_name" id="village_name" value="<?php echo $village_name;?>" /> 
			</td>
		</tr>
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="date">
					<?php echo JText::_( 'Date' ); ?>:
				</label>
			</td>
       		 <td>
			<?php echo JHTML::_('calendar', $this->track->date, 'date', 'date',
   '%Y-%m-%d',
   array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      'onclick'=> "return showCalendar('date','%Y-%m-%d');",
      'onfocus'=> "return showCalendar('date','%Y-%m-%d');"));
?>

			</td>
          </tr>
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="number">
					<?php echo JText::_( 'Number' ); ?>:
				</label>
			</td>
			<td>
<input class="text_area"  type="text" name="number" id="number" size="10" maxlength="10" value="<?php echo $this->track->number;?>" />
		
			</td>
		</tr>
            
	</table>
	
	</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="expedition_id" value="<?php echo $this->track->expedition_id;?>" />

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->track->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="track" />
</form>
