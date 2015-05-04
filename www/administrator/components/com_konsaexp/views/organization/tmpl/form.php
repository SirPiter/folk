<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php 
//jimport('joomla.application.component.view');


JHTML::_('behavior.calendar'); 
// Load the tooltip behavior.
//JHtml::_('behavior.tooltip');
//JHtml::_('behavior.formvalidation');
//JHtml::_('behavior.keepalive');
?>
<?php 		//cridem el CSS
		$document	= & JFactory::getDocument();
		$document->addStyleSheet('components/com_konsaexp/assets/albums.css');
		?>


<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_KONSAEXP_DOCUMENT_DETAILS' ); ?></legend>
			<ul class="adminformlist">
				<li>
					<label for="Name"><?php echo JText::_( 'COM_KONSAEXP_ORGANIZATION_NAME' ); ?>:</label>
					<input class="text_area" type="text" name="name" id="name" size="48" maxlength="250" value="<?php echo $this->organization->name;?>" /></li>
				<li>	
					<label for="Code">	<?php echo JText::_( 'COM_KONSAEXP_ORGANIZATION_CODE' ); ?>:	</label>
					<input class="text_area" type="text" name="code" id="code" size="48" maxlength="10" value="<?php echo $this->organization->code;?>" /></li>
			</ul>
			<div class="clr"></div>
			<label for="review"><?php echo JText::_( 'COM_KONSAEXP_COMMENT' ); ?>:</label>
	    	<div class="clr"></div>
	        <?php
			$editor =& JFactory::getEditor();
			echo $editor->display('comment', $this->organization->comment, '100%', '200', '60', '20', false);
			?>
	</fieldset>
</div>
	
<div class="width-40 fltrt">
<fieldset class="panelform">
    <ul class="adminformlist">
        <li>
	        <label for="metadescription"><?php echo JText::_( 'COM_KONSAEXP_METADESCRIPTION' ); ?>:</label>
	        <textarea id="metadesc" class="inputbox" rows="3" cols="30" name="metadesc" aria-invalid="false"></textarea>
        </li>

        <li>
	        <label for="metakey"><?php echo JText::_( 'COM_KONSAEXP_METAKEY' ); ?>:</label>
	        <textarea id="metakey" class="inputbox" rows="3" cols="30" name="metakey" aria-invalid="false"></textarea>
        </li>
        <li>
	        <label for="autor"><?php echo JText::_( 'COM_KONSAEXP_AUTOR' ); ?>:</label>
	        <span style="float: left; margin: 5px 5px 5px 0px; width: auto;"><?php echo $this->user->name; ?></span>
        </li>
        <li>
	        <label for="createdate"><?php echo JText::_( 'COM_KONSAEXP_CREATEDATE' ); ?>:</label>
	         <span style="float: left; margin: 5px 5px 5px 0px; width: auto;"><?php echo JHTML::_('date', $this->organization->created, JText::_('DATE_FORMAT_LC3'));?></span>
        </li>
        <li>
	        <label for="modified_date"><?php echo JText::_( 'COM_KONSAEXP_MODIFIED_DATE' ); ?>:</label>
	        <span style="float: left; margin: 5px 5px 5px 0px; width: auto;"><?php echo JHTML::_('date', $this->organization->modified, JText::_('DATE_FORMAT_LC3'));?></span>
	        <input  type="hidden" name="modified_by" value="<?php echo $this->user->id;?>" />
            <input  type="hidden" name="modified" id="modified" value="<?php echo JHTML::_('date', now, "Y-m-d H:i:s" );?>" />
        </li>
        <li>
	        <label for="ID"><?php echo JText::_( 'COM_KONSAEXP_RECORD_ID' ); ?>:</label>
	        <span style="float: left; margin: 5px 5px 5px 0px; width: auto;"><?php echo $this->organization->id; ?></span>
        </li>
    </ul>
</fieldset></div>		
<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->organization->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="organization" />
</form>
