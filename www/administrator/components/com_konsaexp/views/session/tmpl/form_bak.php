<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<?php // Закладка основных данных
jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs', array('startOffset' => $this->tab ));
echo $pane->startPane( 'pane' );
echo $pane->startPanel( JText::_('COM_KONSAEXP_SESSION_DETAILS'), 'panel1' );
echo $this->loadTemplate('panel1'); 
echo $pane->endPanel();
?>

<?php  // Вторая закладка
if($this->session->id){
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
<!--	<div id="module-menu">
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
-->

	<fieldset class="adminform"> <!-- Блок для добавления документов -->
    <legend><?php echo JText::_( 'Expedition document list' ); ?></legend>

<br/>&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:new_doc();" value="<? echo JText::_('Add new document'); ?>"/>
&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:new_file();" value="<? echo JText::_('Add new file '); ?>"/>
&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:delete_selected_docs();" value="<? echo JText::_('Delete selected documents'); ?>"/>
<br/><br/>
<?php print_r($docs); ?>
<table class="adminlist" id="docs_table">

	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->documents ); ?>);" />
			</th>	
		
         <th>
				<?php echo JText::_( 'Document title' ); ?>
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
	for ($i=0, $n=count( $this->docs ); $i < $n; $i++)	{
		$doc = &$this->docs[$i];
		$checked 	= JHTML::_('grid.id',   $i, $doc->id );
		$link_edit = JRoute::_( 'index.php?option=com_konsaexp&controller=document&task=edit&cid[]=' . $doc->id );
		$tick = JHTML::image("administrator/images/tick.png",JText::_('Yes'));
		$tick_file = JHTML::image("administrator/images/tick.png",JText::_('Yes'),array("title" => $doc->filename));
		$cross = JHTML::image("administrator/images/publish_x.png",JText::_('No'));
		$link_open = JRoute::_( "..".DS.$doc->soundfile );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $doc->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
            <td align="left"  style="padding-left:10px;">
				<a href="<? echo $link_edit; ?>"><?php echo $doc->title;?></a>
			</td>
                
            <td align="center">
            <? if ($doc->soundfile) { ?>
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
  <input class="button" type="button" onclick="javascript:new_phonogram();" value="<? echo JText::_('Add new document'); ?>"/>
  <br />

</fieldset>



<?php
	echo $pane->endPanel(); 
	echo $pane->startPanel( JText::_('COM_KONSAEXP_PHOTOS'), 'panel5' );?>
<div id="submenu-box">
			<div class="m">
				<div id="toolbar" class="toolbar-list" style="text-align:center; float:left">

<a class="toolbar" onclick="Joomla.submitbutton('cancel')" href="#">
<span class="icon-32-cancel" style="  display: none;
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
<input type="hidden" name="id" value="<?php echo $this->session->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="session" />
</form>
