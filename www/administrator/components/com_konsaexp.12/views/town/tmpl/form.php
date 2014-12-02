<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="town">
					<?php echo JText::_( 'Town' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="town_name" id="name" size="32" maxlength="250" value="<?php echo $this->town->town_name;?>" />
			</td>
		</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="town">
					<?php echo JText::_( 'Coordinata' ); ?>:
				</label>
			</td>

			<td>
				<input class="text_area" type="text" name="coordinata" id="coordinata" size="32" maxlength="250" value="<?php echo $this->town->coordinata;?>" />
			</td>
				</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="town">
					<?php echo JText::_( 'Oldname' ); ?>:
				</label>
			</td>

			<td>
				<input class="text_area" type="text" name="oldname" id="oldname" size="32" maxlength="250" value="<?php echo $this->town->oldname;?>" />
			</td>

		</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="town">
					<?php echo JText::_( 'Rename year' ); ?>:
				</label>
			</td>

			<td>
				<input class="text_area" type="text" name="rename_year" id="rename_year" size="32" maxlength="250" value="<?php echo $this->town->rename_year;?>" />
			</td>
		</tr>

        <tr>
			<td width="100" align="right" class="key">
				<label for="type">
					<?php echo JText::_( 'Type' ); ?>:
				</label>
			</td>
			<td>
             <select name="type" id="type">
             <option value="?">--<? echo JText::_('None'); ?>--</option>

            <?php
          //  print_r($this->towntype_list);die;
			//for ($t=0, $n=count( $this->towntype_list );$t < $n; $t++)	{
//			$row = &$this->towntype_list[$t];
//			$selected = "";
//			if($row->type == $this->towntype_list[$t]) $selected = "selected";
?>
         <!--   <option <?php //echo $selected;?> value="<?php //echo $row->type;?>"><?php //echo $row->type;?></option>
           --> <?php // } ?>



             <option
<?php if(strcmp($this->town->type, JText::_('Town')) == 0) echo  " selected "; ?>
					value="<? echo JText::_('Town'); ?>"><? echo JText::_('Town'); ?></option>
             <option <?php if(strcmp($this->town->type, JText::_('Город')) == 0) echo  " selected "; ?>
value="<? echo JText::_('Город'); ?>"><? echo JText::_('Город'); ?></option>
             <option <?php if(strcmp($this->town->type, JText::_('Поселок городского типа')) == 0) echo  " selected "; ?>
value="<? echo JText::_('Поселок городского типа'); ?>"><? echo JText::_('Поселок городского типа'); ?></option>
             <option <?php if(strcmp($this->town->type, JText::_('Село')) == 0) echo  " selected "; ?>
value="<? echo JText::_('Село'); ?>"><? echo JText::_('Село'); ?></option>
             <option <?php if(strcmp($this->town->type, JText::_('Деревня')) == 0) echo  " selected "; ?>
value="<? echo JText::_('Деревня'); ?>"><? echo JText::_('Деревня'); ?></option>
             <option <?php if(strcmp($this->town->type, JText::_('Хутор')) == 0) echo  " selected "; ?>
value="<? echo JText::_('Хутор'); ?>"><? echo JText::_('Хутор'); ?></option>
             <option <?php if(strcmp($this->town->type, JText::_('Станица')) == 0) echo  " selected "; ?>
value="<? echo JText::_('Станица'); ?>"><? echo JText::_('Станица'); ?></option>

			</select>
			</td>
		</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="subname">
					<?php echo JText::_( 'Subname' ); ?>:
				</label>
			</td>

			<td>
				<input class="text_area" type="text" name="subname" id="subname" size="32" maxlength="250" value="<?php echo $this->town->subname;?>" />
			</td>
		</tr>


        <tr>
			<td width="100" align="right" class="key">
				<label for="region">
					<?php echo JText::_( 'Region' ); ?>:
				</label>
			</td>
			<td>
             <select name="region" id="region">
             <option value="0">--<? echo JText::_('None'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->regions );$i < $n; $i++)	{
			$row = &$this->regions[$i];
			$selected = "";
			if($row->id == $this->town->region) $selected = "selected";
?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->region_name;?></option>
            <?php  } ?>
			</select>
			</td>
		</tr>


        <tr>
			<td width="100" align="right" class="key">
				<label for="comment">
					<?php echo JText::_( 'Comment' ); ?>:
				</label>
			</td>
			<td>
            <?php
				$editor =& JFactory::getEditor();
				echo $editor->display('comment', $this->town->comment, '550', '200', '60', '20', false);
			?>
			</td>
		</tr>


	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->town->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="town" />
</form>
