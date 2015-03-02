<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_KONSAEXP_PHOTO_DETAILS' ); ?></legend>

		<table class="admintable" border=0>
			<tr>
				<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_TITLE' ); ?>:
				</label>
				</td>
				<td>
					<input class="text_area" type="text" name="title" id="title" size="100" maxlength="250" value="<?php echo $this->doc->title;?>" />
				</td>
			</tr>
			<tr>
			<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_SHORT_DESCRIPTION' ); ?>:
				</label>
			</td>
			<td>
			<!--	<input class="text_area" type="text" name="short_description" id="short_description" size="64" maxlength="250" value="<?php //echo $this->doc->short_description;?>" />  -->
                <textarea class="text_area" type="text" name="short_description" id="short_description" cols="40" rows="3" ><?php echo $this->doc->short_description;?></textarea>
			</td>
			</tr>
		<tr>
			<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_DESCRIPTION' ); ?>:
				</label>
			</td>
			<td >
				
<?php			$editor_desc =& JFactory::getEditor();
				echo $editor_desc->display('description', $this->doc->description, '500', '150', '60', '20', false, 'description');
?>
                
			</td>

		</tr>
		<tr>
			<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_DATE' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JHTML::_('calendar', $this->doc->date, 'date', 'date',
   '%Y-%m-%d',
   array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      'onclick'=> "return showCalendar('doc_date','%Y-%m-%d');",
      'onfocus'=> "return showCalendar('doc_date','%Y-%m-%d');"));
?>
			</td>
			</tr>
			<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_PLACE' ); ?>:
				</label>
			</td>
		<td>
       <select name="place_id" id="place_id">
             <option value="0">-- <? echo JText::_('COM_KONSAEXP_NONE'); ?> --</option>
            <?php
			for ($i=0, $n=count( $this->towns );$i < $n; $i++)	{
			$row = &$this->towns[$i];
			$selected = "";
			if($row->id == $this->doc->place_id) $selected = "selected";
  ?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->town_name;?></option>
            <?php  } ?>
			</select>
		</td>
		</tr>

		<tr>
			<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_ADD_DATE' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JHTML::_('calendar', $this->doc->add_date, 'add_date', 'add_date',
   '%Y-%m-%d',
   array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      'onclick'=> "return showCalendar('add_date','%Y-%m-%d');",
      'onfocus'=> "return showCalendar('add_date','%Y-%m-%d');"));
?>
			</td>
		</tr>
       <tr>
			<td  align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_EXPEDITION' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->expedition[0]->expedition_title;?>
                <input type="hidden" name="expedition_id" value="<?php echo $this->expedition[0]->id; ?>" />
              	<param name="mycalendar" type="calendar" default="5-10-2008" label="Select a date" description="" format="%d-%m-%Y" />
			</td>
		</tr>

			<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_COLLECTOR' ); ?>:
				</label>
			</td>
		<td>
       <select name="collector_id" id="collector_id">
             <option value="0">-- <? echo JText::_('COM_KONSAEXP_NONE'); ?> --</option>
            <?php
			for ($i=0, $n=count( $this->collectors );$i < $n; $i++)	{
			$row = &$this->collectors[$i];
			$selected = "";
			if($row->id == $this->doc->collector_id) $selected = "selected";
  ?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->collector_name;?></option>
            <?php  } ?>
			</select>
		</td>
		</tr>
 

        <tr>
			<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_PHOTO_PATH' ); ?>:
				</label>
			</td>
			<td>

<input class="text_area" type="text" name="path" id="path" size="100" maxlength="250" value="<?php echo $this->doc->path;?>" />
&nbsp<br>
      <a rel="{handler: 'iframe', size: {x: 600, y: 530}}" onclick="IeCursorFix(); return false;"  href="<?php echo JRoute::_( 'index.php?option=com_filepicker&tmpl=component&e_name=path') ?>" title="Filelink" class="modal-button"> <input type="submit" value="<?php echo JText::_( 'COM_KONSAEXP_BROWSE' ); ?>" /></a>
          &nbsp;
          <button onclick="document.getElementById('path').value='';this.form.getElementById('path').value='0';this.form.getElementById('path').value=''; return false;"><?php echo JText::_( 'COM_KONSAEXP_CLEAR_LINK' ); ?></button>
          &nbsp;
			<?php        
          if ($this->doc->path) {	
		?>
		<button onclick="javascript:window.location='<?php echo $this->doc->path?>'; return false;" ><?php echo JText::_( 'COM_KONSAEXP_DOWNLOAD_LINK' ); ?> </button>

		<?php } ?>
			</td>

		</tr>
<!--        <tr>
			<td width="100" align="right" class="key">
				<label for="related">
					<?php echo JText::_( 'Related' ); ?>:
				</label>
			</td>
        <td>
			<select multiple="multiple" name="related[]" id="related" size="10">
				<?php
			for ($i=0, $n=count( $this->related );$i < $n; $i++)	{
			$row = &$this->related[$i];
			$selected = "";
			if( in_array($row->id,$this->collector->related) ) $selected = "selected";?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->collector_name;?></option>
            <?php } ?>
			</optgroup>
			</td>
          </tr>
   -->

    <tr>
			<td align="right" class="key">
				<label for="review">
					<?php echo JText::_( 'COM_KONSAEXP_COMMENT' ); ?>:
				</label>
			</td>
			<td>
            <?php
				$editor =& JFactory::getEditor();
				echo $editor->display('comment', $this->doc->comment, '500', '200', '60', '20', false);
			?>
			</td>
		</tr>

	</table>
	</fieldset>
</div>

<div class="preview width-40 fltrt" >
	
	<?php
	if ($this->doc->path) {
		echo "<embed id='preview' src='".$this->doc->path."' width='100%' height='500'/>";
		}	?>

</div>

<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->doc->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="photo" />
</form>
