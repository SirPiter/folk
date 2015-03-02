<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="region">
					<?php echo JText::_( 'Region' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="region_name" id="region_name" size="32" maxlength="250" value="<?php echo $this->region->region_name;?>" />
			</td>
		</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="okrug">
					<?php echo JText::_( 'Okrug' ); ?>:
				</label>
			</td>

			<td>
				<input class="text_area" type="text" name="okrug" id="okrug" size="32" maxlength="250" value="<?php echo $this->region->okrug;?>" />
			</td>
				</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="capital">
					<?php echo JText::_( 'Capital' ); ?>:
				</label>
			</td>

			<td>
				<input class="text_area" type="text" name="capital" id="capital" size="32" maxlength="250" value="<?php echo $this->region->capital;?>" />
			</td>

		</tr>

		<tr>
			<td width="100" align="right" class="key">
				<label for="region_code">
					<?php echo JText::_( 'Region code' ); ?>:
				</label>
			</td>

			<td>
				<input class="text_area" type="text" name="region_code" id="region_code" size="32" maxlength="32" value="<?php echo $this->region->region_code;?>" />
			</td>
		</tr>

        <tr>
			<td width="100" align="right" class="key">
				<label for="comment">
					<?php echo JText::_( 'Comment' ); ?>:
				</label>
			</td>
			<td>
            <?php
				$editor =& JFactory::getEditor();
				echo $editor->display('comment', $this->region->comment, '550', '200', '60', '20', false);
			?>
			</td>
		</tr>

	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_konsaexp" />
<input type="hidden" name="id" value="<?php echo $this->region->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="region" />
</form>
