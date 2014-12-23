<?php
/**
 * @version     2.5.14
 * @package     com_konsaexp
 * @copyright   
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access'); 
?>

<fieldset class="adminform">  <!-- Блок для основных данных сессии: название, код, краткие даты  -->
<legend><?php echo JText::_( 'COM_KONSAEXP_MAIN' ); ?></legend>
<table class="admintable" border=0>
	<tr>   <!-- строка для кода сессии -->
		<td width="100" align="right" class="key">
			<label for="session_code">
			<?php echo JText::_( 'COM_KONSAEXP_SESSION_CODE' ); ?>:
			</label>
		</td>
		<td>
			<input class="text_area" type="text" name="session_code" id="session_code" size="30" maxlength="100" value="<?php echo $this->data->session_code;?>" />
		</td>
	</tr>
    <tr>   <!-- строка для темы  -->
		<td width="100" align="right" class="key">
			<label for="session_title">
				<?php echo JText::_( 'COM_KONSAEXP_SESSION_TITLE' ); ?>:
			</label>
		</td>
		<td>
			<input class="text_area" type="text" name="session_title" id="session_title" size="87" maxlength="250" value="<?php echo $this->data->session_title;?>" />
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key">
			<label for="Begin date">
			<?php echo JText::_( 'COM_KONSAEXP_SESSION_DATE' ); ?>:
			</label>
		</td>
		<td width="140">
			<?php echo JHTML::_('calendar', $this->data->date, 'date', 'date', '%Y-%m-%d',
			array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
			'onclick'=> "return showCalendar('begin_date','%Y-%m-%d');",
			'onfocus'=> "return showCalendar('begin_date','%Y-%m-%d');"));
			?>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key">
			<label for="session_place">
				<?php echo JText::_( 'COM_KONSAEXP_SESSION_PLACE' ); ?>:
			</label>
		</td>
		<td>
			<select name="place_id" id="place_id">
            <option value="0">--<? echo JText::_('COM_KONSAEXP_NONE'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->townswithregions );$i < $n; $i++)	{
			$row = &$this->townswithregions[$i];
			$selected = "";
			if($row->id == $this->data->place_id) $selected = "selected";
  			?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->town_name;?></option>
            <?php  } ?>
			</select>
		</td>

		</tr>
		<tr>
		<td width="100" align="right" class="key">
			<label for="session_expedition">
				<?php echo JText::_( 'COM_KONSAEXP_SESSION_EXPEDITION' ); ?>:
			</label>
		</td>
		<td>
			<select name="expedition_id" id="expedition_id">
            <option value="0">--<? echo JText::_('COM_KONSAEXP_NONE'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->expeditions );$i < $n; $i++)	{
			$row = &$this->expeditions[$i];
			$selected = "";
			if($row->id == $this->data->expedition_id) $selected = "selected";
  			?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->expedition_title;?></option>
            <?php  } ?>
			</select>
		</td>

		</tr>
		
		
		
		
		<tr>
		<td width="100" align="right" class="key">
			<label for="review">
			<?php echo JText::_( 'COM_KONSAEXP_COMMENT' ); ?>:
			</label>
		</td>
		<td>
			<?php
				$editor =& JFactory::getEditor();
				echo $editor->display('comment', $this->data->comment, '450', '200', '60', '20', false);
			?>
		</td>
	</tr>
</table>
</fieldset>
