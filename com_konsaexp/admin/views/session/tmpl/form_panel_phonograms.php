<?php
/**
 * @version     2.5.14
 * @package     com_konsaexp
 * @copyright   
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access'); 
?>

<fieldset class="adminform"> <!-- Блок для добавления фонограмм -->
    <legend><?php echo JText::_( 'COM_KONSAEXP_SESSION_PHONOGRAM_LIST' ); ?></legend>

<br/>&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:new_phonogram();" value="<? echo JText::_('COM_KONSAEXP_ADD_NEW_PHONOGRAM'); ?>"/>
&nbsp;&nbsp;
<!--  
<input class="button" type="button" onclick="javascript:new_file();" value="<? echo JText::_('Add new file '); ?>"/>
&nbsp;&nbsp;
 -->
<input class="button" type="button" onclick="javascript:delete_selected_phonograms();" value="<? echo JText::_('COM_KONSAEXP_DELETE_SELECTED_PHONOGRAMS'); ?>"/>
<br/><br/>
<table class="adminlist" id="phonograms_table">

	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'COM_KONSAEXP_ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->phonograms ); ?>);" />
			</th>	
		
         <th>
				<?php echo JText::_( 'COM_KONSAEXP_PHONOGRAM_TITLE' ); ?>
			</th>
            <th width="20">
				<?php echo JText::_( 'COM_KONSAEXP_PHONOGRAM_LINK' ); ?>
			</th>
            <th width="20">
				<?php echo JText::_( 'COM_KONSAEXP_PHONOGRAM_EDIT' ); ?>
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
		$tick_file = JHTML::image("administrator/images/tick.png",JText::_('Yes'),array("title" => $phonogram->soundfile));
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
  <input class="button" type="button" onclick="javascript:new_phonogram();" value="<? echo JText::_('COM_KONSAEXP_ADD_NEW_PHONOGRAM'); ?>"/>
  <br />

</fieldset>
