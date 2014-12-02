<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.calendar'); ?>



<h2> <?php echo JText::_( 'Expedition details' )." : ".$this->expedition->expedition_title;?></h2>
<?php


jimport('joomla.html.pane');
$pane =& JPane::getInstance('tabs', array('startOffset' => $this->tab ));
echo $pane->startPane( 'pane' );
echo $pane->startPanel( JText::_('Expedition details'), 'panel1' );
//print_r($this->expedition); die;
?>

	<fieldset class="adminform">  <!-- Блок для основных данных экспедиции: название, руководитель, краткие даты  -->
		<legend><?php echo JText::_( 'Main' ); ?></legend>
        <table class="admintable" border=0>
	    	<tr>   <!-- строка для темы экспедиции -->
			<td width="auto" align="right" class="key">	<?php echo JText::_( 'Expedition title' ); ?>: </td>
			<td colspan="3"> <?php echo $this->expedition->expedition_title;?> </td>
            </tr>
       		<tr>   <!-- строка для руководителя экспедиции -->
	       <td width="auto" align="right" class="key">
					<?php echo JText::_( 'Chief Collector' ); ?>:
			</td>
		<td colspan="3"> 	
		<a class='llista_artista' style='width:100%;' 
        href='<?php echo JRoute::_( 'index.php?option=com_konsaexp&view=collector&id='. $this->collector->id ); ?>'  
        title="Все экспедиции руководителя">  <?php echo $this->collector->collector_full_name;?>  </a>
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
			<td width="140"> <?php echo $this->expedition->begin_date ?>
			</td>
			<td width="100" align="right" class="key">
            	<label for="End date">
					<?php echo JText::_( 'End date' ); ?>:
				</label>
			</td>
			<td width="396">  <?php echo $this->expedition->begin_date ?>
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
			print_r( $this->expedition->comment);
//				$editor =& JFactory::getEditor();
//				echo $editor->display('comment', $this->expedition->comment, '450', '200', '60', '20', false);
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
<table class="adminlist" id="tracks_table">

	<thead>
		<tr>

         <th width="40">
				<?php echo JText::_( 'Number' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Town' ); ?>
			</th>
            <th width="100">
				<?php echo JText::_( 'Visiting date' ); ?>
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
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>    

</fieldset>
<?php
	echo $pane->endPanel();
    echo $pane->startPanel( JText::_('Phonograms'), 'panel3' ); // Закладка для добавления фонограмм
	?>
	<fieldset class="adminform"> <!-- Блок для добавления фонограмм -->
    <legend><?php echo JText::_( 'Expedition phonogram list' ); ?></legend>

<table class="adminlist" id="phonograms_table">

	<thead>
		<tr>
         <th>
				<?php echo JText::_( 'Phonogram title' ); ?>
			</th>
            <th width="100">
				<?php echo JText::_( 'Record place' ); ?>
			</th>
            <th width="80">
				<?php echo JText::_( 'Record date' ); ?>
			</th>
            <th width="70">
				<?php echo JText::_( 'Подробнее' ); ?>
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
            <td align="center">
				<a href="<? echo $link_open; ?>"  title="<? echo JText::_( 'Open this phonogram' ); ?>"  ><?php echo $phonogram->phonogram_title;?></a>
			</td>
            <td>
                
            <?php
			for ($j=0, $p=count( $this->towns );$j < $p; $j++)	{
			$town = &$this->towns[$j];
			if($town->id == $phonogram->town_id) { echo $town->town_name; break; }
			} ?>
              
                
	    </td>
            <td align="center">
				<? echo $phonogram->recorddate; ?>
			</td>
           <td width="70" align="center" onclick="javascript: show_hide_row(<?php echo $i; ?>, <?php echo $n; ?>);">
				<span style="text-decoration:underline; cursor:pointer;"> <?php echo JText::_( 'Подробнее' ); ?> </span>
           	</td>

		</tr>
        <tr  id="<?php echo "inforow$i"; ?>"  style="display: none" >
          <td colspan="4">
              <?php  if($phonogram->text) { ?>
			<h4 style="background:#EEE; padding:10px; margin:0;">	<?php   echo JText::_( 'Текст: ' ); ?>  </h4>
	          <?php  echo  $phonogram->text; ?>
			<hr /> 
			<?php } 
			if ($phonogram->comment) { ?>
				<h4 style="background:#EEE; padding:10px; margin:0;">	<?php   echo JText::_( 'Комментарий: ' ); ?>  </h4>
	        	  <?php  echo  $phonogram->comment; 
			}?>
              
          </td>
        </tr>
		<?php
		$k = 1 - $k;
	}

	?>
	</table>    

</fieldset>
	<?php
	echo $pane->endPanel();
//    echo $pane->startPanel( JText::_('Photos'), 'panel4' );
//	echo $pane->endPane();
}
?>

<div class="clr"></div>

