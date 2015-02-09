<?php
defined('_JEXEC') or die;
echo JHtml::_('sliders.panel',JText::_('COM_KONSAEXP_META'), 'meta-details'); 
?>

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
	         <span style="float: left; margin: 5px 5px 5px 0px; width: auto;"><?php echo JHTML::_('date', $this->artist->created, JText::_('DATE_FORMAT_LC3'));?></span>
        </li>
        <li>
	        <label for="modified_date"><?php echo JText::_( 'COM_KONSAEXP_MODIFIED_DATE' ); ?>:</label>
	        <span style="float: left; margin: 5px 5px 5px 0px; width: auto;"><?php echo JHTML::_('date', $this->artist->modified, JText::_('DATE_FORMAT_LC3'));?></span>
	        <input  type="hidden" name="modified_by" value="<?php echo $this->user->id;?>" />
            <input  type="hidden" name="modified" id="modified" value="<?php echo JHTML::_('date', now, "Y-m-d H:i:s" );?>" />
        </li>
        <li>
	        <label for="ID"><?php echo JText::_( 'COM_KONSAEXP_RECORD_ID' ); ?>:</label>
	        <span style="float: left; margin: 5px 5px 5px 0px; width: auto;"><?php echo $this->artist->id; ?></span>
        </li>
        
    </ul>
</fieldset>