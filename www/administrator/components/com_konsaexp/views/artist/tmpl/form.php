<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_DETAILS' ); ?></legend>

		<table class="admintable">
			<tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_FULLNAME' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="artist_full_name" id="artist_full_name" size="64" maxlength="250" value="<?php echo $this->artist->artist_full_name;?>" />
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
                if($this->artist->letter == $key) $selected = "selected";?>
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
				<input class="text_area" type="text" name="artist_lastname" id="artist_lastname" size="48" maxlength="250" value="<?php echo $this->artist->artist_lastname;?>" />
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
			if($row->id == $this->artist->place) $selected = "selected";
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
				<input class="text_area" type="text" name="artist_name" id="artist_name" size="48" maxlength="250" value="<?php echo $this->artist->artist_name;?>" />
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
				<input class="text_area" type="text" name="artist_secondname" id="artist_secondname" size="48" maxlength="250" value="<?php echo $this->artist->artist_secondname;?>" />
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
				<?php echo JHTML::_('calendar', $this->artist->birth_date, 'birth_date', 'birth_date',
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
			if($row->id == $this->artist->place_of_birth) $selected = "selected";
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
				<?php echo JHTML::_('calendar', $this->artist->death_date, 'death_date', 'death_date',
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
			if($row->id == $this->artist->place_of_death) $selected = "selected";
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
				<input class="text_area" type="text" name="class_name" id="class_name" size="32" maxlength="250" value="<?php echo $this->artist->class_name;?>" />
			</td>
<td>


	<param name="mycalendar" type="calendar" default="5-10-2008" label="Select a date" description="" format="%d-%m-%Y" />
</td>
<td></td>
		</tr>

  </table>

  <table class="admintable" >


        <tr>
			<td width="100" align="right" class="key">
				<label for="greeting">
					<?php echo JText::_( 'COM_KONSAEXP_IMAGE_FOR_ARTIST' ); ?>:
				</label>
			</td>
			<td>

<input class="text_area" type="text" name="image" id="image" size="64" maxlength="250" value="<?php echo $this->artist->image;?>" />
&nbsp <input type="file" name="artist_image_file" size="45"/>
		<?php
		if($this->artist->image != "") {?>  <p align="center">
			<img style="max-height:300px;" src="../images/artists/<?php echo $this->artist->image;?>"/>
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
			if( in_array($row->id,$this->artist->related) ) $selected = "selected";?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->artist_name;?></option>
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
				echo $editor->display('comment', $this->artist->comment, '450', '200', '60', '20', false);
			?>
			</td>
		</tr>

	</table>

	</fieldset>
</div>
	
<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

			<?php echo $this->loadTemplate('sessions'); ?>
			<?php //echo $this->loadTemplate('phonogramms'); ?>
			<?php //echo $this->loadTemplate('parameters'); ?>
			<?php //echo $this->loadTemplate('metadata'); ?>

		<?php echo JHtml::_('sliders.end'); ?>
</div>		
<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->artist->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="artist" />
</form>
