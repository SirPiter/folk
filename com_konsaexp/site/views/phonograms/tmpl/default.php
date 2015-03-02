<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal','a.modal'); ?>

<?
	$itemid = $this->params->get('itemid');
	if($itemid != "") $itemid = "&Itemid=" . $itemid;
//print_r($this->items);
?>

<? if($this->letter == "") { 
	echo $this->introtext; ?>      

<form action="index.php" method="get" title="<? echo JText::_('Phonograms list'); ?>" name="adminForm">

<h1><? echo JText::_('Phonograms list'); ?></h1>
<table  align="left">
	<tr>
		<td width="100%">
		<?php echo JText::_( 'Search' ); ?>:
		<input type="text" name="keywords" id="keywords" value="<?php echo $this->keywords;?>" class="text_area" size="40" maxlength="255" /> <button onclick="document.adminForm.limitstart.value=0; submitform();return false;"><?php echo JText::_( 'Search Phonograms' ); ?></button>
 
 <? if ($this->keywords) { ?>
    &nbsp;
    <button onclick="document.getElementById('phonogram_keys').value='';document.getElementById('keywords').value='';this.form.getElementById('keywords').value='0';this.form.getElementById('keywords').value=''; this.form.getElementById('phonogram_keys').value='0';this.form.getElementById('phonogram_keys').value='';document.adminForm.limitstart.value=0;this.form.submit();"><?php echo JText::_( 'All phonograms' ); ?></button>
    <? } ?>
    <hr />
		</td>
	</tr>
</table>

     <table class="adminlist" width="100%">
     	<thead>
		<tr>
			<th>
				<?php // echo JText::_( 'Expedition theme' ); ?>
                <?php  echo JHTML::_( 'grid.sort', 'Phonogram title', 'phonogram_title', $this->lists['phon_filter_order_Dir'], $this->lists['phon_filter_order']); ?>
          <!--      <a href="javascript:table1Ordering('phonogram_title','asc','');" title="Phonogram title">Training provider</a>  -->
			</th>
            <th align="center">
				<?php //echo JText::_( 'Expedition Chief' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Expedition title', 'expedition_title', $this->lists['phon_filter_order_Dir'], $this->lists['phon_filter_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Record Date' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Record Date', 'recorddate', $this->lists['phon_filter_order_Dir'], $this->lists['phon_filter_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Record Place' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Record Place', 'town_name', $this->lists['phon_filter_order_Dir'], $this->lists['phon_filter_order']); ?>
			</th>
            <th align="center" width="70">
				<?php echo JText::_( 'Подробнее' ); ?>
			</th>
		</tr>
	</thead>
<?php    

	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$phonogram = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $phonogram->id );
		$link_edit = JRoute::_( 'index.php?option=com_konsaexp&controller=phonogram&task=edit&cid[]=' . $phonogram->id );
		$tick = JHTML::image("administrator/images/tick.png",JText::_('Yes'));
		$tick_file = JHTML::image("administrator/images/tick.png",JText::_('Yes'),array("title" => $phonogram->filename));
		$cross = JHTML::image("administrator/images/publish_x.png",JText::_('No'));
		$link_open = JRoute::_( "..".DS.$phonogram->soundfile );
		
		$link_exp= JRoute::_( 'index.php?option=com_konsaexp&view=expedition&id='. $phonogram->expedition_id  );


		?>
		<tr class="<?php echo "row$k"; ?>">
            <td align="center">
            	<?php if($phonogram->soundfile){ ?>
				<a href="<? echo $link_open; ?>"  title="<? echo JText::_( 'Open this phonogram' ); ?>"  ><?php echo $phonogram->phonogram_title;?></a>
				<?php } else {
                	echo $phonogram->phonogram_title;
				} ?>
            </td>
            <td  style='padding-left:5px;'>
            		<a class='llista_artista' style='width:100%;' href='<?php echo $link_exp; ?>' title="Подробное описание экспедиции">
			      	<?php echo $phonogram->expedition_title; ?></a>
        	</td>
         	<td align="center"><?php echo $phonogram->recorddate; ?></td>
         	<td align="center"><?php echo $phonogram->town_name; ?></td>
       	
            <td width="70" align="center" onclick="javascript: show_hide_row(<?php echo $i; ?>, <?php echo $n; ?>);">
				<span style="text-decoration:underline; cursor:pointer;"> <?php echo JText::_( 'Подробнее' ); ?> </span>
           	</td>

		</tr>
        <tr  id="<?php echo "inforow$i"; ?>"  style="display: none;" >
          <td colspan="5">
              <?php  if($phonogram->text) { ?>
			<h4 style="background:#EEE; padding:10px; margin:0;">	<?php   echo JText::_( 'Текст: ' ); ?>  </h4>
	          <?php  echo  $phonogram->text; ?>
			<hr /> 
			<?php } 
			if ($phonogram->comment) { ?>
				<h4 style="background:#EEE; padding:10px; margin:0;">	<?php   echo JText::_( 'Комментарий: ' ); ?>  </h4>
	        	  <?php  echo  $phonogram->comment; 
			}
			
			// echo $link_open;?>
              
          </td>
        </tr>
		<?php
		$k = 1 - $k;
	}
     
?>

    <tfoot>
    <tr>
      <td colspan="5"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  	</tfoot>

</table>

<? } ?>
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['phon_filter_order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['phon_filter_order_Dir']; ?>" />
    <input type="hidden" name="option" value="com_konsaexp" />
    <input type="hidden" name="view" value="phonograms" />
    <input type="hidden" name="Itemid" value="<?php echo $this->params->get('itemid'); ?>" />
    <input type="hidden" name="phonogram_keys"  id="phonogram_keys" value=""/><br />
</form>


<div class="konsaexpfooter"><?  echo KonsaExpHelper::showKonsaExpFooter(); ?></div>
