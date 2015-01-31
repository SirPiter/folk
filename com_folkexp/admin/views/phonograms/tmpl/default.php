<?php defined('_JEXEC') or die('Restricted access'); ?>
    <script>
      audiojs.events.ready(function() {
        audiojs.createAll();
      });
    </script>

<form action="index.php" method="post" name="adminForm">

<!-- audiojs_.create(element, settings)  -->

<script>
  audiojs.events.ready(function() {
    var as = audiojs.createAll();
  });
</script>

<div id="editcell">

                <table>
                        <tr>
					<td width="100%">
						<?php echo JText::_( 'COM_KONSAEXP_FILTER' ); ?>:
						<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" onchange="document.adminForm.submit();" /> <button onclick="this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_GO_SEARCH' ); ?></button>
<button onclick="document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value='';this.form.submit();"><?php echo JText::_( 'COM_KONSAEXP_FILTER_RESET' ); ?></button>
                        </td>
                        </tr>
                    </table>




	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'COM_KONSAEXP_ID' ); ?>
			</th>
			<th width="20">
            	<?php 
				$counter = 0;
				for ($i=0, $n=count( $this->items ); $i < $n; $i++){ 
							if($this->items[$i]->num_albums == 0) $counter++;
				}
				?>
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo $counter; ?>);" />
			</th>			
			<th>
				<?php echo JText::_( 'COM_KONSAEXP_PHONOGRAM_TITLE' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'COM_KONSAEXP_EXPEDITION' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'COM_KONSAEXP_RECORD_DATE' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'COM_KONSAEXP_RECORD_PLACE' ); ?>
			</th>
            <th width="50">
				<?php echo JText::_( 'COM_KONSAEXP_PLAY' ); ?>
			</th>
            
		</tr>
	</thead>

	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ),$check_i = 0; $i < $n; $i++)	{
		$row = &$this->items[$i];
		
		if($row->num_albums) $checked 	= "";
		else {
			$checked 	= JHTML::_('grid.id',   $check_i, $row->id );
			$check_i++;
		}
		$link 		= JRoute::_( 'index.php?option=com_konsaexp&controller=phonogram&task=edit&parent_controller=phonograms&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td <?php if($row->display_group) echo "style='padding-left:50px;'" ?>>
				<a href="<?php echo $link; ?>"><?php echo $row->phonogram_title; ?></a>
			</td>
             <td>
			<? 	for ($j=0, $p=count( $this->expeditions );$j < $p; $j++)	{
					if($row->expedition_id == $this->expeditions[$j]->id) echo $this->expeditions[$j]->expedition_title;
				} 	?>
            <td>
				<?php echo $row->recorddate; ?>
			</td> 
             <td>
			<?  for ($j=0, $p=count( $this->towns );$j < $p; $j++)	{
					if($row->town_id == $this->towns[$j]->id) echo $this->towns[$j]->town_name;
				} 	?>
			</td> 
            <td>
<!-- 			<div id="audioplayer_<?php echo $row->id; ?>">Для отображения плеера необходим Flash и javascript</div>  
        		<script type="text/javascript">  
				AudioPlayer.embed("audioplayer_<?php echo $row->id; ?>", {soundFile: "<?php  echo 'folklab.ru/mp3/'. substr_replace($row->soundfile, 'mp3', -3); ?>"});  
				</script> 
 <audio src="<?php  echo 'http://folklab.ru/mp3/'. substr_replace($row->soundfile, 'mp3', -3); ?>" preload="none"></audio>
 
 -->
 
 <?php 
 $afile= substr_replace($row->soundfile, 'mp3', -3);
 $afile=str_replace("library/audio/","library/mp3/",$afile);
 $afile=urlencode($afile);
 $afile=str_replace("+","%20",$afile);
 $afile=str_replace("%2F","/",$afile);
 //$afile= "http://folklab.ru/". $afile;
 $afile= JURI::base(). '../'.$afile;
 
//echo $afile;
 	//print_r(file_exists($afile));
 $Headers = @get_headers($afile);
 //print_r($Headers[0]);
 	if (strpos($Headers[0], '200')) {
 		//echo " Exist!";
 		echo '<audio src="'.$afile.'" preload="none"></audio>';
 		
 	}
 	?> 
 			</td> 

		</tr>
		<?php
		$k = 1 - $k;
	}
	?>

    <tfoot>
    <tr>
      <td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

	</table>
</div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="phonogram" />
</form>
