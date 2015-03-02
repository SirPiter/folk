<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<div class="col100">
	<fieldset class="adminform">
	  <legend><?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_DETAILS' ); ?></legend>
		<?php //print_r($this); die; ?>
		<table class="admintable" border="0">
		<tr>
			<td width="100" align="right" class="key">
				<label for="ID"><?php echo JText::_( 'COM_KONSAEXP_PHONOGRAM' ); ?>:
				</label>
			</td>
			<td width="687"> <!--  ID: <?php echo $this->phonogram->id;?>, -->
            &nbsp;&nbsp;
            <input class="text_area"  type="text" name="phonogram_title" id="phonogram_title" size="100" maxlength="200" value="<?php echo $this->phonogram->phonogram_title;?>" /></td>
		  </tr>
<!-- 	<tr>
			<td width="100" align="right" class="key">
				<label for="Expedition ID">
					<?php echo JText::_( 'COM_KONSAEXP_EXPEDITION' ); ?>:
				</label>
			</td>
			<td>ID: <?php echo $this->phonogram->expedition_id;?>, 
            &nbsp;&nbsp;&nbsp;<?php echo $this->expedition[0]->expedition_title;?></td>
		  </tr>
		<tr>
 -->
		<tr>
		<td width="100" align="right" class="key">
			<label for="phonogram_expedition">
				<?php echo JText::_( 'COM_KONSAEXP_EXPEDITION' ); ?>:
			</label>
		</td>
		<td>
			<select name="expedition_id" id="expedition_id">
            <option value="0">--<? echo JText::_('COM_KONSAEXP_NONE'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->expeditions );$i < $n; $i++)	{
			$row = &$this->expeditions[$i];
			$selected = "";
			if($row->id == $this->phonogram->expedition_id) $selected = "selected";
  			?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->expedition_title;?></option>
            <?php  } ?>
			</select>
		</td>
		</tr>
		
		<tr>
		<td width="100" align="right" class="key">
			<label for="phonogram_session">
				<?php echo JText::_( 'COM_KONSAEXP_SESSION' ); ?>:
			</label>
		</td>
		<td>
			<select name="session_id" id="session_id">
            <option value="0">--<? echo JText::_('COM_KONSAEXP_NONE'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->sessions );$i < $n; $i++)	{
			$row = &$this->sessions[$i];
			$selected = "";
			if($row->id == $this->phonogram->session_id) $selected = "selected";
  			?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->session_title;?></option>
            <?php  } ?>
			</select>
		</td>
		</tr>
		
		
		
<!-- 		<tr>
			<td width="100" align="right" class="key">
				<label for="Session ID">
					<?php echo JText::_( 'COM_KONSAEXP_SESSION' ); ?>:
				</label>
			</td>
			<td>ID: <?php echo $this->phonogram->session_id;?>, 
            &nbsp;&nbsp;&nbsp;<?php echo $this->expedition[0]->session_title;?></td>
		  </tr>
		<tr>
	 -->
	
		<td align="right" class="key"><label for="Collector ID"> <?php echo JText::_( 'COM_KONSAEXP_COLLECTOR' ); ?>: </label></td>
		  <td><?php echo $this->phonogram->collector_id;?>
          	 <select name="collector_id" id="collector_id">
			    <?php
			for ($i=0, $n=count( $this->collectors );$i < $n; $i++)	{
			$row = &$this->collectors[$i];
			$selected = ""; 
			if($row->id == $this->phonogram->collector_id) $selected = "selected";
			?>
			    <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->collector_full_name;?></option>
			    <?php } ?>
		      </select>
          </td>
		  </tr>
        <tr>
			<td width="100" align="right" class="key">
				<label for="artist"><?php echo JText::_( 'COM_KONSAEXP_RECORD_PLACE' ); ?>:
				</label>
			</td>
			<td>
			  <select name="town_id" id="town_id">
			    <?php
			for ($i=0, $n=count( $this->townswithregions );$i < $n; $i++)	{
			$row = &$this->townswithregions[$i];
			$selected = ""; 
			if($row->id == $this->phonogram->town_id) $selected = "selected";
			?>
			    <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->town_name.', '.$row->region_name;?></option>
			    <?php } ?>
		      </select></td>
		  </tr>
        
        <tr>
			<td width="100" align="right" class="key">
				<label for="recorddate">
					<?php echo JText::_( 'COM_KONSAEXP_RECORD_DATE' ); ?>:
				</label>
			</td>
			<td><?php echo JHTML::_('calendar', $this->phonogram->recorddate, 'recorddate', 'recorddate',
   '%Y-%m-%d',
   array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      'onclick'=> "return showCalendar('date','%Y-%m-%d');",
      'onfocus'=> "return showCalendar('date','%Y-%m-%d');"));
?></td>
		  </tr>
        
        <tr valign="middle">
			<td width="100" align="right" class="key">
				<label for="SoundFile">
					<?php echo JText::_( 'COM_KONSAEXP_SOUNDFILE' ); ?>:
				</label>
			</td>
			<td valign="middle">
            <a rel="{handler: 'iframe', size: {x: 600, y: 530}}" onclick="IeCursorFix(); return false;"  href="<?php echo JRoute::_( 'index.php?option=com_filepicker&tmpl=component&e_name=soundfile') ?>" title="Filelink" class="modal-button"> <input type="submit" value="<?php echo JText::_( 'COM_KONSAEXP_BROWSE' ); ?>" /></a>
          &nbsp;
          <a  href="javascript:document.getElementById('soundfile').value='';this.form.getElementById('soundfile').value='0';this.form.getElementById('soundfile').value='';"  title="clear_link" class="button"> <input type="reset" value="<?php echo JText::_( 'COM_KONSAEXP_CLEAR_LINK' ); ?>" /></a>
         &nbsp; 
            <input class="text_area"  type="text" name="soundfile" id="soundfile" size="100" maxlength="100" value="<?php echo $this->phonogram->soundfile;?>"   />&nbsp;&nbsp;
            <a  href="" onclick="location.href='../'+document.getElementById('soundfile').value;return false;"  
            title="Open" class="button"> <input type="button" value="<?php echo JText::_( 'COM_KONSAEXP_OPEN' ); ?>" /></a>
            
        
           </td>
		  </tr>

        <tr>
			<td width="100" align="right" class="key">
				<label for="TextFile">
					<?php echo JText::_( 'COM_KONSAEXP_TEXTFILE' ); ?>:
				</label>
			</td>
			<td><input class="text_area"  type="text" name="textfile" id="textfile" size="100" maxlength="100" value="<?php echo $this->phonogram->textfile;?>" />			  <a rel="{handler: 'iframe', size: {x: 600, y: 530}}" onclick="IeCursorFix(); return false;"  href="<?php echo JRoute::_( 'index.php?option=com_filepicker&tmpl=component&e_name=textfile') ?>" title="Filelink" class="modal-button">
			  <input type="submit" value="<?php echo JText::_( 'COM_KONSAEXP_BROWSE' ); ?>" />
			</a>
           </td>
		  </tr>

        <tr>
          <td align="right" class="key">
          	<label for="Text">
					<?php echo JText::_( 'COM_KONSAEXP_TEXT' ); ?>:
				</label>
				</td>
          <td>
            <?php
				$editor =& JFactory::getEditor();
				echo $editor->display('text', $this->phonogram->text, '650', '200', '60', '20', false);
			?>
          </td>
        </tr>
        <tr>
          <td align="right" class="key">
          	<label for="Comment">
					<?php echo JText::_( 'COM_KONSAEXP_COMMENT' ); ?>:
				</label>
				</td>
          <td>   <?php
				$editor1 =& JFactory::getEditor();
				echo $editor1->display('comment', $this->phonogram->comment, '650', '200', '60', '20', false); ?>
          </td>
        </tr>
            
      </table>
	
	</fieldset>
</div>

<div class="clr"></div>

<input type="hidden" name="expedition_id" value="<?php echo $this->phonogram->expedition_id;?>" />
<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->phonogram->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="phonogram" />
<input type="hidden" name="parent_controller" value="<?php echo JRequest::getVar('parent_controller') ?>" />
<input type="hidden" name="tab" value="<?php echo JRequest::getVar('tab') ?>" />
</form>
