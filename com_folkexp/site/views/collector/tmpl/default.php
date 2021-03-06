<?php defined('_JEXEC') or die('Restricted access'); ?>


<div class="collector_photo">
<? if ($this->collector->image){ 
	$collector_photo = 'images'.DS.'collectors'.DS.$this->collector->image;  
	} else { 
	$collector_photo = 'components/com_konsaexp/assets/images/No_image_available.gif' ;  } ?>

<img src="<?php echo $collector_photo?>" title="Photo" width="200px"  />

</div>
<div class="collector_info">
<h2><? echo $this->collector->collector_lastname ?> <br />
<? echo $this->collector->collector_name ?> <br />
<? echo $this->collector->collector_secondname ?></h2>
<p>Родился :&nbsp;<? echo $this->collector->birth_date ?>, &nbsp;
<? echo $this->collector->name_place_of_birth ?></p>
<p>Жил :&nbsp;<? echo $this->collector->name_place ?>, &nbsp;
<? if ($this->collector->name_place_of_death) { ?>
<p>Умер :&nbsp;<? echo $this->collector->birth_date ?>, &nbsp;
<? echo $this->collector->name_place_of_death ?></p>
<? } ?>
</div>
<div style="display:block; clear:both;"> <? echo $this->collector->comment ?> </div>
<hr />

<h1>Список экспедиций</h1>


     <table class="adminlist" width="100%">
     	<thead>
		<tr>
			<th>
				<?php // echo JText::_( 'Expedition theme' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Expedition theme', 'expedition_title', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Expedition Chief' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Expedition Chief', 'chief_collector', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
            <th align="center">
				<?php //echo JText::_( 'Year' ); ?>
                <?php echo JHTML::_( 'grid.sort', 'Year', 'year_begin', $this->lists['exp_order_Dir'], $this->lists['exp_order']); ?>
			</th>
		</tr>
	</thead>
<?php    
for ($i=0, $n=count( $this->expeditions ); $i < $n; $i++)	{
	$row = &$this->expeditions[$i];

	$link_exp= JRoute::_( 'index.php?option=com_konsaexp&view=expedition&id='. $row->id  );
	$link_call= JRoute::_( 'index.php?option=com_konsaexp&view=collector&id='. $row->chief_collector  );
	 ?>
    <tr>
	    <td  style='padding-left:5px;'>
		          <a class='llista_artista' style='width:100%;' href='<?php echo $link_exp; ?>' title="Подробное описание экспедиции">
					 <?php echo $row->expedition_title; ?></a>
         </td>
                              <td  style='padding-left:5px;'>
                     <a class='llista_artista' style='width:100%;' href='<?php echo $link_call; ?>'  title="Все экспедиции руководителя">
					 <?php echo $row->collector_full_name; ?>
                     </a>
                </td>
                <td align="center"><?php echo $row->year_begin; ?></td>

    </tr>

<?php

	 // end if
}      
?>
</table>

<div class="konsaexpfooter"><? echo KonsaExpHelper::showKonsaExpFooter(); ?></div>

