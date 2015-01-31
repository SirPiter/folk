<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php 
$itemid = $this->params->get('itemid');
if($itemid != "") $itemid = "&Itemid=" . $itemid;
$link = JRoute::_( 'index.php?option=com_muscol&view=artist&id='. $this->artist->id . $itemid); ?>
        <div class="artist_detailed">
            <div class="artist_name">
                <a href='<? echo $link; ?>'><? echo $this->artist->artist_name; ?></a>
            </div>
            <table width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td valign="top" width="20%">
                        <div class="num_albums">
                        <? echo JText::_('Albums'); ?>: <? echo $this->artist->num_albums; ?>
                        </div>
                        <div class="num_songs">
                        <? if($this->artist->num_songs){
							$link_songs = JRoute::_( 'index.php?option=com_muscol&view=songs&id='. $this->artist->id . $itemid);
							$songs = "<a href='".$link_songs."'>".JText::_('Songs')."</a>";	
						}
						else $songs = JText::_('Songs'); ?>
                        <? echo $songs; ?>: <? echo $this->artist->num_songs; ?>
                        </div>
                    </td>
                    <td valign="top" style="text-align:left;">
                    <? foreach($this->artist->albums as $album){
						$link_album = JRoute::_( 'index.php?option=com_muscol&view=album&id='. $album->id . $itemid);
						$image_album = JHTML::image('images/albums/thumbs_40/' . $album->image, $album->name, array("title" => $album->name)); ?>
                        <a class="artists_album" href="<? echo $link_album; ?>"><? echo $image_album; ?></a>
                    <? } ?>
                    </td>
                </tr>
            </table>            
		</div>