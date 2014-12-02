<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<?php
jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs', array('startOffset' => $this->tab ));
echo $pane->startPane( 'pane' );
echo $pane->startPanel( JText::_('COM_KONSAEXP_EXPEDITION_DETAILS'), 'panel1' );
//print_r($this->expedition); die;
?>

	<fieldset class="adminform">  <!-- Блок для основных данных экспедиции: название, руководитель, краткие даты  -->
		<legend><?php echo JText::_( 'COM_KONSAEXP_MAIN' ); ?></legend>
        <table class="admintable" border=0>
	    	<tr>   <!-- строка для темы экспедиции -->
			<td width="100" align="right" class="key">
				<label for="expedition_title">
					<?php echo JText::_( 'Expedition title' ); ?>:
				</label>
			</td>

			<td colspan="3">
				<input class="text_area" type="text" name="expedition_title" id="expedition_title" size="100" maxlength="250" value="<?php echo $this->expedition->expedition_title;?>" />
			</td>
            </tr>
       		<tr>   <!-- строка для руководителя экспедиции -->
	       <td width="100" align="right" class="key">
				<label for="chief_collector">
					<?php echo JText::_( 'Chief Collector' ); ?>:
				</label>
			</td>
		<td colspan="3">
		<select name="chief_collector" id="chief_collector">
             <option value="0">--<? echo JText::_('None'); ?>--</option>
            <?php
			for ($i=0, $n=count( $this->collectors );$i < $n; $i++)	{
			$row = &$this->collectors[$i];
			$selected = "";
			if($row->id == $this->expedition->chief_collector) $selected = "selected";
  ?>
            <option <?php echo $selected;?> value="<?php echo $row->id;?>"><?php echo $row->collector_full_name;?></option>
            <?php  } ?>
			</select>
		</td>
		</tr>
			<tr>    <!-- строка для даты начала экспедиции (месяц, год) -->
			<td width="100" align="right" class="key">
				<label for="short_begin">
					<?php echo JText::_( 'Start date' ); ?>:
				</label>
			</td>
		  <td width="140">
				<input class="text_area" type="text" name="year_begin" id="year_begin" size="4" maxlength="10" value="<?php echo $this->expedition->year_begin;?>" />
			<select name="month_begin" id="month_begin">
            <option value="0"></option>
            <?php 
			for ($i=1; $i <= 12; $i++)	{
			$selected = ""; 
			if($i == $this->expedition->month_begin) $selected = "selected";?>
            <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $this->displayMonth($i);?></option>
            <?php } ?>
			</select></td>
		  <td width="100" align="right" class="key">
          <label for="short_end">
					<?php echo JText::_( 'End date' ); ?>:
				</label></td>
		  <td width="398"><input class="text_area" type="text" name="year_end" id="year_end" size="4" maxlength="10" value="<?php echo $this->expedition->year_end;?>" />
			<select name="month_end" id="month_end">
            <option value="0"></option>
            <?php 
			for ($i=1; $i <= 12; $i++)	{
			$selected = ""; 
			if($i == $this->expedition->month_end) $selected = "selected";?>
            <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $this->displayMonth($i);?></option>
            <?php } ?>
			</select>
            </td>

		</tr>
		</table>
    </fieldset>

  <fieldset class="adminform"> <!-- Блок для дополнительных данных экспедиции: точные даты, комментарий  -->
    <legend><?php echo JText::_( 'Optional' ); ?></legend>
	  <table class="admintable" border=0>
        
   		  <tr>
			  <td width="100" align="right" class="key">
				<label for="Begin date">
					<?php echo JText::_( 'Begin date' ); ?>:
				</label>
			</td>
			<td width="140">
				<?php echo JHTML::_('calendar', $this->expedition->begin_date, 'begin_date', 'begin_date', '%Y-%m-%d',
   array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      'onclick'=> "return showCalendar('begin_date','%Y-%m-%d');",
      'onfocus'=> "return showCalendar('begin_date','%Y-%m-%d');"));
?>
			</td>
			<td width="100" align="right" class="key">
            	<label for="End date">
					<?php echo JText::_( 'End date' ); ?>:
				</label>
			</td>
			<td width="396">
            	<?php echo JHTML::_('calendar', $this->expedition->end_date, 'end_date', 'end_date', '%Y-%m-%d',
   array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19',
      'onclick'=> "return showCalendar('end_date','%Y-%m-%d');",
      'onfocus'=> "return showCalendar('end_date','%Y-%m-%d');"));
?>
            </td>
		  </tr>
        
        
		  <tr>
			  <td width="100" align="right" class="key">
				  <label for="review">
					  <?php echo JText::_( 'Comment' ); ?>:
				  </label>
			  </td>
			<td colspan="3">
            <?php
				$editor =& JFactory::getEditor();
				echo $editor->display('comment', $this->expedition->comment, '450', '200', '60', '20', false);
			?>
			</td>
		</tr>

    </table>
    </fieldset>


<?php
echo $pane->endPanel();
if($this->expedition->id){
	echo $pane->startPanel( JText::_('Tracks'), 'panel2' );
?>

<?php
$select_town='<option selected disabled>--'.JText::_('None')."--</option>";
	for ($i=0, $n=count( $this->townswithregions );$i < $n; $i++)	{
	$row = &$this->townswithregions[$i]; 
$select_town=$select_town.' <option value="'.$row->id.'">'.$row->town_name.', '.$row->region_name.'</option>';
            } 
?>
<script language="javascript">
var select_town='<?php echo $select_town ?>';
</script>
<fieldset class="adminform"> <!-- Блок для маршрута экспедиции -->
    <legend><?php echo JText::_( 'Expedition tracks' ); ?></legend>

<br/>&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:new_track();" value="<? echo JText::_('Add new track'); ?>"/>
&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:delete_selected_tracks();" value="<? echo JText::_('Delete selected tracks'); ?>"/>
<br/><br/>

<table class="adminlist" id="tracks_table">

	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->tracks ); ?>);" />
			</th>	
		
         <th width="40">
				<?php echo JText::_( 'Number' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Town' ); ?>
			</th>
            <th width="100">
				<?php echo JText::_( 'Visiting date' ); ?>
			</th>
            <th width="20">
				<?php echo JText::_( 'Edit' ); ?>
			</th>
            
		</tr>
	</thead>
	<?php
	
	$k = 0;
	for ($i=0, $n=count( $this->tracks ); $i < $n; $i++)	{
		$track = &$this->tracks[$i];
		$checked 	= JHTML::_('grid.id',   $i, $track->id );
		$link_edit = JRoute::_( 'index.php?option=com_konsaexp&controller=track&task=edit&cid[]=' . $track->id );
		$tick = JHTML::image("administrator/images/tick.png",JText::_('Yes'));
		$tick_file = JHTML::image("administrator/images/tick.png",JText::_('Yes'),array("title" => $track->filename));
		$cross = JHTML::image("administrator/images/publish_x.png",JText::_('No'));
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $track->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
            <td align="center">
				<?php echo $track->number;?>
			</td>
            <td>
                
            <?php
			for ($j=0, $p=count( $this->townswithregions );$j < $p; $j++)	{
			$town = &$this->townswithregions[$j];
			if($town->id == $track->town_id) { echo $town->town_name.', '.$town->region_name; break; }
			} ?>
              
                
	    </td>
            <td align="center">
				<? echo $track->date; ?>
			</td>
            <td align="center">
				<a href="<? echo $link_edit; ?>"><img src="components/com_konsaexp/assets/images/icons/page_white_edit.png" title="<? echo JText::_( 'Edit this track' ); ?>" alt="<? echo JText::_( 'Edit this track' ); ?>" /></a>
			</td>

		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>    

<br />&nbsp;&nbsp;
  <input class="button" type="button" onclick="javascript:new_track();" value="<? echo JText::_('Add new track'); ?>"/>
  <br />
</fieldset>
<?php
	echo $pane->endPanel();
    echo $pane->startPanel( JText::_('Phonograms'), 'panel3' ); // Закладка для добавления фонограмм
	?>
	<fieldset class="adminform"> <!-- Блок для добавления фонограмм -->
    <legend><?php echo JText::_( 'Expedition phonogram list' ); ?></legend>

<br/>&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:new_phonogram();" value="<? echo JText::_('Add new phonogram'); ?>"/>
&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:new_file();" value="<? echo JText::_('Add new file '); ?>"/>
&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:delete_selected_phonograms();" value="<? echo JText::_('Delete selected phonograms'); ?>"/>
<br/><br/>
<table class="adminlist" id="phonograms_table">

	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->phonograms ); ?>);" />
			</th>	
		
         <th>
				<?php echo JText::_( 'Phonogram title' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Record place' ); ?>
			</th>
            <th width="100">
				<?php echo JText::_( 'Record date' ); ?>
			</th>
            <th width="20">
				<?php echo JText::_( 'Link' ); ?>
			</th>
            <th width="20">
				<?php echo JText::_( 'Edit' ); ?>
			</th>
            
		</tr>
	</thead>
	<?php
	
	$k = 0;
	for ($i=0, $n=count( $this->phonograms ); $i < $n; $i++)	{
		$phonogram = &$this->phonograms[$i];
		$checked 	= JHTML::_('grid.id',   $i, $phonogram->id );
		$link_edit = JRoute::_( 'index.php?option=com_konsaexp&controller=phonogram&task=edit&cid[]=' . $phonogram->id );
		$tick = JHTML::image("administrator/images/tick.png",JText::_('Yes'));
		$tick_file = JHTML::image("administrator/images/tick.png",JText::_('Yes'),array("title" => $phonogram->filename));
		$cross = JHTML::image("administrator/images/publish_x.png",JText::_('No'));
		$link_open = JRoute::_( "..".DS.$phonogram->soundfile );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $phonogram->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
            <td align="left"  style="padding-left:10px;">
				<a href="<? echo $link_edit; ?>"><?php echo $phonogram->phonogram_title;?></a>
			</td>
            <td  style="padding-left:10px;">
                
            <?php
			for ($j=0, $p=count( $this->towns );$j < $p; $j++)	{
			$town = &$this->towns[$j];
			if($town->id == $phonogram->town_id) { echo $town->town_name; break; }
			} ?>
              
                
	    </td>
            <td align="center">
				<? echo $phonogram->recorddate; ?>
			</td>
            <td align="center">
            <? if ($phonogram->soundfile) { ?>
				<a href="<? echo $link_open; ?>"><img src="components/com_konsaexp/assets/images/music.png" title="<? echo JText::_( 'Open this phonogram' ); ?>" alt="<? echo JText::_( 'Open this phonogram' ); ?>" /></a>
             <? } ?>   
			</td>
            <td align="center">
				<a href="<? echo $link_edit; ?>"><img src="components/com_konsaexp/assets/images/icons/page_white_edit.png" title="<? echo JText::_( 'Edit this phonogram' ); ?>" alt="<? echo JText::_( 'Edit this phonogram' ); ?>" /></a>
			</td>

		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>    

<br />&nbsp;&nbsp;
  <input class="button" type="button" onclick="javascript:new_phonogram();" value="<? echo JText::_('Add new phonogram'); ?>"/>
  <br />

</fieldset>
	<?php
	echo $pane->endPanel();
    echo $pane->startPanel( JText::_('COM_KONSAEXP_DOCUMENTS'), 'panel4' );
	?>
	<div id="module-menu">
			<ul id="menu">
<li class="node"><a href="#">Добавить</a><ul>
<li><a href="index.php" class="icon-16-cpanel">Фонограмму</a></li>
<li class="separator"><span></span></li>
<li><a href="index.php?option=com_admin&amp;task=profile.edit&amp;id=655" class="icon-16-profile">Документ</a></li>
<li class="separator"><span></span></li>
<li><a href="index.php?option=com_config" class="icon-16-config">Фото</a></li>
<li class="separator"><span></span></li>

</ul>

		</div>




<?php
	echo $pane->endPanel(); 
	echo $pane->startPanel( JText::_('COM_KONSAEXP_PHOTOS'), 'panel5' );?>
<div id="submenu-box">
			<div class="m">
				<div id="toolbar" class="toolbar-list" style="text-align:center; float:left">

<a class="toolbar" onclick="Joomla.submitbutton('cancel')" href="#">
<span class="icon-32-cancel" style="  display: block;
    float: none;
    height: 32px;
    margin: 0 auto;
    width: 32px;">
</span>
Close
</a>

</div></div>
		</div>
   <?php 
	
	echo $pane->endPanel();
}
?>

<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->expedition->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="expedition" />
</form>
