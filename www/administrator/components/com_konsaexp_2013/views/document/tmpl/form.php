<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_DETAILS' ); ?></legend>

		<table class="admintable" border=0>
			<tr>
				<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_TITLE' ); ?>:
				</label>
				</td>
				<td>
					<input class="text_area" type="text" name="title" id="title" size="100" maxlength="250" value="<?php echo $this->doc->title;?>" />
				</td>
			</tr>
			<tr>
			<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_SHORT_DESCRIPTION' ); ?>:
				</label>
			</td>
			<td>
			<!--	<input class="text_area" type="text" name="short_description" id="short_description" size="64" maxlength="250" value="<?php //echo $this->doc->short_description;?>" />  -->
                <textarea class="text_area" type="text" name="short_description" id="short_description" cols="40" rows="3" ><?php echo $this->doc->short_description;?></textarea>
			</td>
			</tr>
			<tr>
				<td align="right" class="key" valign="top">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_NUM_OF_PAGES' ); ?>:
				</label>
				</td>
		<td valign="top">
        <input  name="num_of_pages" id="num_of_pages" type="integer" default="Some integer" label="Choose an integer" description="" first="1" last="100" step="1" value="<?php echo $this->doc->num_of_pages;?>" style="width:40px"/>
		</td>

		</tr>
		<tr>
			<td align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_DESCRIPTION' ); ?>:
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
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_DOC_DATE' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JHTML::_('calendar', $this->doc->doc_date, 'doc_date', 'doc_date',
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
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_PLACE' ); ?>:
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
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_ADD_DATE' ); ?>:
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
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_EXPEDITION' ); ?>:
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
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_COLLECTOR' ); ?>:
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
					<?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_PATH' ); ?>:
				</label>
			</td>
			<td>

<input class="text_area" type="text" name="doc_path" id="doc_path" size="100" maxlength="250" value="<?php echo $this->doc->doc_path;?>" />
&nbsp<br>
      <a rel="{handler: 'iframe', size: {x: 600, y: 530}}" onclick="IeCursorFix(); return false;"  href="<?php echo JRoute::_( 'index.php?option=com_filepicker&tmpl=component&e_name=doc_path') ?>" title="Filelink" class="modal-button"> <input type="submit" value="<?php echo JText::_( 'COM_KONSAEXP_BROWSE' ); ?>" /></a>
          &nbsp;
          <a  href="javascript:document.getElementById('doc_path').value='';this.form.getElementById('doc_path').value='0';this.form.getElementById('doc_path').value='';"  title="clear_link" class="button"> <input type="reset" value="<?php echo JText::_( 'COM_KONSAEXP_CLEAR_LINK' ); ?>" /></a>
          &nbsp;
			<?php        
          if ($this->doc->doc_path) {	
		?>
		<input type="button" value="<?php echo JText::_( 'COM_KONSAEXP_DOWNLOAD_LINK' ); ?>" onclick="javascript:window.location='<?php echo $this->doc->doc_path?>'"/>
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
				echo $editor->display('doc_comment', $this->doc->doc_comment, '500', '200', '60', '20', false);
			?>
			</td>
		</tr>

	</table>
	</fieldset>
</div>

<div class="preview width-40 fltrt" >
	
	<?php
	if ($this->doc->doc_path) {
		echo "<embed src='".$this->doc->doc_path."' width='100%' height='500'/>";
		}	?>

</div>

<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->doc->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="document" />
</form>
