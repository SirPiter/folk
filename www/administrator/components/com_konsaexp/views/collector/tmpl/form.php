<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_DETAILS' ); ?></legend>

		<table class="admintable" border=0>
			<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_FULLNAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="collector_full_name" id="collector_full_name" size="64" maxlength="250" value="<?php echo $this->collector->collector_full_name;?>" />
			</td>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_LETTER' ); ?>:
				</label>
			</td>
			<td>
                <select name="letter" id="letter">
                <option value=""></option>
                <?php
				$letters = array("А" => "А",
								 "Б" => "Б",
								 "В" => "В",
								 "Г" => "Г",
								 "Д" => "Д",
								 "Е" => "Е",
								 "Ж" => "Ж",
								 "З" => "З",
								 "И" => "И",
								 "К" => "К",
								 "Л" => "Л",
								 "М" => "М",
								 "Н" => "Н",
								 "О" => "О",
								 "П" => "П",
								 "Р" => "Р",
								 "С" => "С",
								 "Т" => "Т",
								 "У" => "У",
								 "Ф" => "Ф",
								 "Х" => "Х",
								 "Ц" => "Ц",
								 "Ч" => "Ч",
								 "Ш" => "Ш",
								 "Щ" => "Щ",
								 "Э" => "Э",
								 "Ю" => "Ю",
								 "Я" => "Я",
								 "A" => "A",
								 "B" => "B",
								 "C" => "C",
								 "D" => "D",
								 "E" => "E",
								 "F" => "F",
								 "G" => "G",
								 "H" => "H",
								 "I" => "I",
								 "J" => "J",
								 "K" => "K",
								 "L" => "L",
								 "M" => "M",
								 "N" => "N",
								 "O" => "O",
								 "P" => "P",
								 "Q" => "Q",
								 "R" => "R",
								 "S" => "S",
								 "T" => "T",
								 "U" => "U",
								 "V" => "V",
								 "W" => "W",
								 "X" => "X",
								 "Y" => "Y",
								 "Z" => "Z",
								 "1" => "123"
								 );
                foreach($letters as $key => $value){
                $selected = "";
                if($this->collector->letter == $key) $selected = "selected";?>
                <option <?php echo $selected;?> value="<?php echo $key;?>"><?php echo $value;?></option>
                <?php } ?>
                </select>
			</td>
	</tr>


		<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_LASTNAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="collector_lastname" id="collector_lastname" size="48" maxlength="250" value="<?php echo $this->collector->collector_lastname;?>" />
			</td>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_TOWN' ); ?>:
				</label>
			</td>
		<td>
       <select name="place" id="place">
             <option value="0">--<? echo JText::_('COM_KONSAEXP_NONE'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->towns );$i < $n; $i++)	{
			$row = &$this->towns[$i];
			$selected = "";
			if($row->id == $this->collector->place) $selected = "selected";
  ?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->town_name;?></option>
            <?php  } ?>
			</select>
		</td>

		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="collector_name" id="collector_name" size="48" maxlength="250" value="<?php echo $this->collector->collector_name;?>" />
			</td>
<td></td>
<td></td>

		</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_SECONDNAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="collector_secondname" id="collector_secondname" size="48" maxlength="250" value="<?php echo $this->collector->collector_secondname;?>" />
			</td>
<td></td>
<td></td>
		</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_BIRTH_DATE' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JHTML::_('calendar', $this->collector->birth_date, 'birth_date', 'birth_date',
   '%Y-%m-%d',
   array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      'onclick'=> "return showCalendar('birth_date','%Y-%m-%d');",
      'onfocus'=> "return showCalendar('birth_date','%Y-%m-%d');"));
?>
			</td>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_BIRTH_PLACE' ); ?>:
				</label>
			</td>
		<td>
       <select name="place_of_birth" id="place_of_birth">
             <option value="0">--<? echo JText::_('COM_KONSAEXP_NONE'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->towns );$i < $n; $i++)	{
			$row = &$this->towns[$i];
			$selected = "";
			if($row->id == $this->collector->place_of_birth) $selected = "selected";
  ?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->town_name;?></option>
            <?php  } ?>
			</select>
		</td>
		</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_DEATH_DATE' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JHTML::_('calendar', $this->collector->death_date, 'death_date', 'death_date',
   '%Y-%m-%d',
   array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      'onclick'=> "return showCalendar('death_date','%Y-%m-%d');",
      'onfocus'=> "return showCalendar('death_date','%Y-%m-%d');"));
?>
			</td>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_DEATH_PLACE' ); ?>:
				</label>
			</td>
		<td>
       <select name="place_of_death" id="place_of_death">
             <option value="0">--<? echo JText::_('COM_KONSAEXP_NONE'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->towns );$i < $n; $i++)	{
			$row = &$this->towns[$i];
			$selected = "";
			if($row->id == $this->collector->place_of_death) $selected = "selected";
  ?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->town_name;?></option>
            <?php  } ?>
			</select>
		</td>
		</tr>
       <tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_CLASSIFICATION_NAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="class_name" id="class_name" size="32" maxlength="250" value="<?php echo $this->collector->class_name;?>" />
			</td>
<td>


	<param name="mycalendar" type="calendar" default="5-10-2008" label="Select a date" description="" format="%d-%m-%Y" /
</td>
<td></td>
		</tr>

  </table>

  <table class="admintable" border=0>


        <tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_IMAGE_FOR_COLLECTOR' ); ?>:
				</label>
			</td>
			<td>

<input class="text_area" type="text" name="image" id="image" size="64" maxlength="250" value="<?php echo $this->collector->image;?>" />
&nbsp <input type="file" name="collector_image_file" size="45"/>
		<?php
		if($this->collector->image != "") {?>  <p align="center">
			<img style="max-height:300px;" src="../images/collectors/<?php echo $this->collector->image;?>"/>
			</p>
	<?php } ?>
			</td>

		</tr>
<!--        <tr>
			<td width="100" align="right" class="key">
				<label for="related">
					<?php echo JText::_( 'COM_KONSAEXP_RELATED' ); ?>:
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
			<td width="100" align="right" class="key">
				<label for="review">
					<?php echo JText::_( 'COM_KONSAEXP_COMMENT' ); ?>:
				</label>
			</td>
			<td>
            <?php
				$editor =& JFactory::getEditor();
				echo $editor->display('comment', $this->collector->comment, '450', '200', '60', '20', false);
			?>
			</td>
		</tr>

	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->collector->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="collector" />
</form>
