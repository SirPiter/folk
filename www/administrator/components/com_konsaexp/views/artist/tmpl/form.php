<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
//jimport('joomla.application.component.view');


JHTML::_('behavior.calendar'); 
// Load the tooltip behavior.
//JHtml::_('behavior.tooltip');
//JHtml::_('behavior.formvalidation');
//JHtml::_('behavior.keepalive');
?>
<?php 		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');
		?>


<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_DETAILS' ); ?></legend>
			<?php
			if($this->artist->image != "") {?>  <p style="float: right; margin-bottom:0;">
			<img style="max-height:180px;" src="../images/artists/<?php echo $this->artist->image;?>"/>
			</p>
			<?php } ?>
			
		
			<ul class="adminformlist">
				<li>
				<label for="lastname"><?php echo JText::_( 'COM_KONSAEXP_LASTNAME' ); ?>:</label>
				<input class="text_area" type="text" name="artist_lastname" id="artist_lastname" size="48" maxlength="250" value="<?php echo $this->artist->artist_lastname;?>" /></li>

				<li>	
					<label for="Name">	<?php echo JText::_( 'COM_KONSAEXP_NAME' ); ?>:	</label>
					<input class="text_area" type="text" name="artist_name" id="artist_name" size="48" maxlength="250" value="<?php echo $this->artist->artist_name;?>" /></li>
				<li>	
					<label for="SecondName">	<?php echo JText::_( 'COM_KONSAEXP_SECONDNAME' ); ?>:	</label>
					<input class="text_area" type="text" name="artist_secondname" id="artist_secondname" size="48" maxlength="250" value="<?php echo $this->artist->artist_secondname;?>" /></li>
				<li>	
					<label for="Town"> <?php echo JText::_( 'COM_KONSAEXP_TOWN' ); ?>:</label>
				    <select name="place" id="place">
             			<option value="0">--<? echo JText::_('COM_KONSAEXP_NONE'); ?>--</option>
            			<?php
							for ($i=0, $n=count( $this->towns );$i < $n; $i++)	{
							$row = &$this->towns[$i];
							$selected = "";
							if($row->id == $this->artist->place) $selected = "selected";  ?>
            			<option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->town_name;?></option>
            			<?php  } ?>
					</select></li>
				<li>					
					<label for="Birth"><?php echo JText::_( 'COM_KONSAEXP_BIRTH_DATE_AND_PLACE' ); ?>:	</label>
					<?php echo JHTML::_('calendar', $this->artist->birth_date, 'birth_date', 'birth_date', '%Y-%m-%d',
   							array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      						'onclick'=> "return showCalendar('birth_date','%Y-%m-%d');",
      						'onfocus'=> "return showCalendar('birth_date','%Y-%m-%d');")); ?>
				    <select name="place_of_birth" id="place_of_birth"  style="margin-left:10px">
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
				</li>	
				<li>
					<label for="Death"><?php echo JText::_( 'COM_KONSAEXP_DEATH_DATE_AND_PLACE' ); ?>:	</label>
					<?php echo JHTML::_('calendar', $this->artist->death_date, 'death_date', 'death_date', '%Y-%m-%d',
					   	array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
					    'onclick'=> "return showCalendar('death_date','%Y-%m-%d');",
					    'onfocus'=> "return showCalendar('death_date','%Y-%m-%d');"));
					?> &nbsp;
					<select name="place_of_death" id="place_of_death" style="margin-left:10px">
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
				</li>
				<li>
					<label for="greeting"><?php echo JText::_( 'COM_KONSAEXP_CLASSIFICATION_NAME' ); ?>:</label>
					<input class="text_area" type="text" name="class_name" id="class_name" size="32" maxlength="250" value="<?php echo $this->artist->class_name;?>" />
				</li>		
				<li>
					<label for="Photo"><?php echo JText::_( 'COM_KONSAEXP_IMAGE_FOR_ARTIST' ); ?>:</label>
					<input class="text_area" type="text" name="image" id="image" size="32" maxlength="250" value="<?php echo $this->artist->image;?>" />
					&nbsp <input type="file" name="artist_image_file" size="45"/>
				</li>
			</ul>
			<div class="clr"></div>
			<label for="review"><?php echo JText::_( 'COM_KONSAEXP_COMMENT' ); ?>:</label>
	    	<div class="clr"></div>
	        <?php
			$editor =& JFactory::getEditor();
			echo $editor->display('comment', $this->artist->comment, '100%', '200', '60', '20', false);
			?>
	</fieldset>
</div>
	
<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

			<?php echo $this->loadTemplate('sessions'); ?>
			<?php //echo $this->loadTemplate('phonogramms'); ?>
			<?php //echo $this->loadTemplate('parameters'); ?>
			<?php echo $this->loadTemplate('metadata'); ?>

		<?php echo JHtml::_('sliders.end'); ?>
</div>		
<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->artist->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="artist" />
</form>
