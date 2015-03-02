<?php
/**
 * @version     2.5.27
 * @package     com_konsaexp
 * @copyright   
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/** custom css **/
//$document = JFactory::getDocument();
//$document->addStyleSheet('../media/com_cats/css/administrator.css');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHTML::_('behavior.calendar');
?>

<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

	<div class="width-60 fltlft">

	<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_CATS_NEW_CAT') : JText::sprintf('COM_CATS_EDIT_CAT', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li>
					<label id="jform_title-lbl" class="hasTip" title="" for="jform_title" aria-invalid="false">Title</label>
					<input id="jform_title" class="inputbox" type="text" size="30" value="test" name="jform[title]" aria-invalid="false">
				</li>

				<li>
					<label id="jform_title-lbl" class="hasTip" title="" for="jform_title" aria-invalid="false">Title</label>
					<input class="text_area" type="text" name="expedition_title" id="expedition_title" size="100" maxlength="250" value="<?php echo $this->expedition->expedition_title;?>" />
				</li>
			</ul>

			<div class="clr"></div>
			<?php // echo $this->form->getLabel('snippet'); ?>
			<div class="clr"></div>
			<?php // echo $this->form->getInput('snippet'); ?>

			<div class="clr"></div>
			<?php // echo $this->form->getLabel('fulltext'); ?>
			<div class="clr"></div>
			<?php // echo $this->form->getInput('fulltext'); ?>
		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

			<?php // echo $this->loadTemplate('publishing'); ?>

			<?php // echo $this->loadTemplate('custom_fields'); ?>

			<?php // echo $this->loadTemplate('parameters'); ?>

			<?php // echo $this->loadTemplate('metadata'); ?>

		<?php echo JHtml::_('sliders.end'); ?>
        </div>
    
<div class="clr"></div>

<div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>
