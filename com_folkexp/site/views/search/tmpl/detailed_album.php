<?php
defined('_JEXEC') or die('Restricted access');

$itemid = $this->params->get('itemid');
if($itemid != "") $itemid = "&Itemid=" . $itemid;
$image_attr = array(
					"class" => "image_115_llista"
					);
$link= JRoute::_( 'index.php?option=com_muscol&view=album&id='. $this->detail_album->id  . $itemid);
$image = MusColHelper::createThumbnail($this->detail_album->image, $this->detail_album->name, $this->params->get('thumb_size_artist_2'), $image_attr);
?>
<div class='data'>
    <table border='0' cellpadding='0' cellspacing='0' width="100%">
        <tr>
            <td valign="top" width="120">
                <a class='image' href='<?php echo $link; ?>'>
                    <?php echo $image; ?>
                </a>
            </td>
            <td valign="top">
            <div class="album_name">
                <table border='0' cellpadding='0' cellspacing='0' width="100%">
                    <tr>
                        <td>
                            <a href='<?php echo $link; ?>'>
                            <?php echo $this->detail_album->name; ?> <?php echo $this->detail_album->subtitle; ?>
                            </a>
                        </td>
                        <td align="right">
                            <?php 
                                
                                for($k=0;$k < count($this->detail_album->tags); $k++){ 
                                    $image_attr = array(
                                            "title" => JText::_( $this->detail_album->tags[$k]->tag_name )
                                            );
                                    $tag_image = JHTML::image('images/tags/' . $this->detail_album->tags[$k]->icon , JText::_( $this->detail_album->tags[$k]->tag_name ) , $image_attr );
                                    if($this->detail_album->tags[$k]->icon != "") echo " ".$tag_image;
                                
                             } ?>
                        </td>
                    </tr>
               </table>
            </div>
            
            	<table border='0' cellpadding='0' cellspacing='0' width="100%">
                    <tr>
                        <td>
                        <div class="artist_name">
                <?php echo $this->detail_album->artist_name; ?> <?php echo $this->detail_album->subartist; ?>
                		</div>
                		</td>
                        <td align="right">
                        <? $comments_image = JHTML::image('components/com_muscol/assets/images/comment.png',JText::_('Comments'),array("title" => JText::_('Comments') ));
						$songs_image = JHTML::image('components/com_muscol/assets/images/music.png',JText::_('Songs'),array("title" => JText::_('Songs') ));?>
                        <? echo $songs_image . " " . $this->detail_album->num_songs; ?> 
                        <? echo $comments_image . " " . $this->detail_album->num_comments; ?>
                        </td>
                    </tr>
               </table>
            
            <div class="rating">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="40%" align="left">
                            <?php echo MusColHelper::show_stars($this->detail_album->points,true); ?> / <?php echo MusColHelper::show_stars($this->detail_album->average_rating); ?>
                        </td>
                        <td width="60%" align="left">
                        <? $image_attr = array(
                                "title" => JText::_('Added on')
                                );
                            echo JHTML::image('components/com_muscol/assets/images/date.png', JText::_('Added on') , $image_attr );
?>
                            <?php echo JHTML::_('date', $this->detail_album->added, JText::_('DATE_FORMAT_LC2')); ?>
                        </td>
                    </tr>
                </table>                                	
            </div>
   <table cellpadding="0" cellspacing="0" width="100%"  class="details">
        <tr>
            <td valign="top" width="33%">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'Released' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo $this->detail_album->year; ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'Format' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo $this->detail_album->format_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'Type' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo implode(" / ",$this->detail_album->types); ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td valign="top" width="33%">
                <table cellpadding="0" cellspacing="0" width="100%">
                   <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'Length' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo MusColHelper::time_to_string($this->detail_album->length); ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'N&deg; discs' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo $this->detail_album->ndisc; ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'Label' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo $this->detail_album->label; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td valign="top" width="33%">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'Genre' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo $this->detail_album->genre_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'Price' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo $this->detail_album->price; ?> <? echo $this->currency; ?>
                        </td>
                    </tr>
                     <tr>
                        <td valign="top" class="label_detailed_album">
                        <?php echo JText::_( 'Catalog N&deg;' ); ?>
                        </td>
                        <td valign="top" class="value_detailed_album">
                        <?php echo $this->detail_album->catalog_number; ?>
                        </td>
                    </tr>
                </table>
            </td>
            </tr>
            </table>
            <?php
             if(count($this->detail_album->subalbums)){
                 ?> 
                 <div class="subalbums">
                 <?
                foreach($this->detail_album->subalbums as $subalbum) {
                    $image_attr = array(
                                "class" => "image_40_llista"
                                );
                    $link= JRoute::_( 'index.php?option=com_muscol&view=album&id='. $subalbum->id . $itemid);
                    $image = JHTML::image('images/albums/thumbs_40/' . $subalbum->image , $subalbum->name , $image_attr );?>
                    <a href='<? echo $link; ?>'><? echo $image; ?></a> 
                <? } ?>
                </div>
             <? } ?>
            </td>
         </tr>
     </table>
</div>