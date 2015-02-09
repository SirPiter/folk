<?php
defined('_JEXEC') or die;
echo JHtml::_('sliders.panel',JText::_('COM_KONSAEXP_FIELDSET_ARTIST_SESSIONS_LIST'), 'session-details'); ?>


<fieldset class="panelform"> <!-- Блок сессий записи -->
<!--     <legend><?php echo JText::_( 'COM_KONSAEXP_ARTIST_SESSIONS_LIST' ); ?></legend>
 -->

<input type=hidden id=select1 value="<?php echo $this->lists["sessions"];?>">

<script type="text/javascript">
	var select_session = '<?php echo $this->lists["sessions"] ?>';
</script>

<input class="button" type="button" onclick="javascript:new_artist_session();" value="<? echo JText::_('COM_KONSAEXP_ADD_NEW_SESSION'); ?>"/>
&nbsp;&nbsp;
<input class="button" type="button" onclick="javascript:delete_selected_sessions();" value="<? echo JText::_('COM_KONSAEXP_DELETE_SELECTED_SESSION'); ?>"/>



<table class="adminlist" id="sessions_table">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'COM_KONSAEXP_ID' ); ?>
			</th>
			<th width="20" style="text-align:center">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->linkedsessions ); ?>);" />
			</th>	
			
	        <th style="text-align:left">
				<?php echo JText::_( 'COM_KONSAEXP_SESSION_TITLE' ); ?>
			</th>
            <th width="20">
				<?php echo JText::_( 'COM_KONSAEXP_SESSION_EDIT' ); ?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->linkedsessions ); $i < $n; $i++)	{
		$linkedsession = &$this->linkedsessions[$i];
		$checked 	= JHTML::_('grid.id',   $i, $linkedsession->id );
		$link_edit = JRoute::_( 'index.php?option=com_konsaexp&controller=session&task=edit&cid[]=' . $linkedsession->session_id );
		$link_remove_session = JRoute::_( 'index.php?option=com_konsaexp&controller=artist&task=remove_session&cid[]=' . $linkedsession->id );
//		$tick = JHTML::image("administrator/images/tick.png",JText::_('Yes'));
//		$tick_file = JHTML::image("administrator/images/tick.png",JText::_('Yes'),array("title" => $phonogram->filename));
//		$cross = JHTML::image("administrator/images/publish_x.png",JText::_('No'));
//		$link_open = JRoute::_( "..".DS.$phonogram->soundfile );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $linkedsession->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
            <td align="left"  style="padding-left:10px;">
            <?php  echo $linkedsession->session_title ?>
			</td>
            <td align="center">
				<a href="<? echo $link_edit; ?>"><img src="components/com_konsaexp/assets/images/icons/page_white_edit.png" title="<? echo JText::_( 'COM_KONSAEXP_EDIT_THIS_SESSION' ); ?>" alt="<? echo JText::_( 'COM_KONSAEXP_EDIT_THIS_SESSION' ); ?>" /></a>
				<a href="#" onclick="javascript:delete_selected_sessions(<?php echo $linkedsession->id; ?>);">
				<img src="components/com_konsaexp/assets/images/icons/cancel.png" title="<? echo JText::_( 'COM_KONSAEXP_DELETE_THIS_SESSION' ); ?>" alt="<? echo JText::_( 'COM_KONSAEXP_DELETE_THIS_SESSION' ); ?>" 
				/></a>
				<?php //echo JHTML::_("link", $link_remove_session, "Удалить", array('class'=>'art-link'));?>
				</td>
		</tr>
		<?php
		$k = 1 - $k;
		} ?>
	</tbody>
	</table>    
	<input type="hidden" name="sessionid" value="" />
	</fieldset>
