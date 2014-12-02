<?php
/**
 * Kunena Component
 * @package Kunena.Administrator.Template
 * @subpackage CPanel
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

$document = JFactory::getDocument();
$document->addStyleSheet( JURI::base(true).'/components/com_konsaexp/media/css/cpanel.css' );
$document->addStyleSheet ( JURI::base(true).'/components/com_konsaexp/media/css/admin.css' );
if (JFactory::getLanguage()->isRTL()) $document->addStyleSheet ( JURI::base().'components/com_konsaexp/media/css/admin.rtl.css' );
?>
<div id="kadmin">
	<div class="kadmin-left"><?php include KPATH_ADMIN.'/views/common/tmpl/menu.php'; ?></div>
	<div class="kadmin-right">
<div class="kadmin-welcome">
	<h3><?php echo JText::_('COM_KONSAEXP_WELCOME');?></h3>
	<p><?php echo JText::_('COM_KONSAEXP_WELCOME_DESC');?></p>
</div>
<div style="border:1px solid #ddd; background:#FBFBFB;">
	<table class="thisform">
		<tr class="thisform">
			<td width="100%" valign="top" class="thisform">
				<div id="cpanel">
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&view=cpanel') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_KCONFIGDESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/settings.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_KCONFIG'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=expeditions') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_EXPEDITIONS_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/expeditions.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_EXPEDITIONS'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=collectors') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_COLLECTORS_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/collectors.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_COLLECTORS'); ?> </span> </a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=phonograms') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_PHONOGRAMS_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/phonograms.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_PHONOGRAMS'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=towns') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_TOWNS_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/house.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_TOWNS');?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=regions') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_REGIONS_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/oldmap.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_REGIONS'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=documents') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_DOCS_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/docs.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_DOCS'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon notready"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=scans') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_SCANS_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/scans.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_SCANS'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon notready"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=notes') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_NOTES_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/notes.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_NOTES'); ?> </span></a> </div>
					</div>
                   	<div class="icon-container">
						<div class="icon notready"> <a href="<?php echo JRoute::_('index.php?option=com_konsaexp&controller=photos') ?>" title="<?php echo JText::_('COM_KONSAEXP_C_PHOTOS_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/photos.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_PHOTOS'); ?> </span></a> </div>
					</div>
                   	<div class="icon-container">
						<div class="icon notready"> <a href="#" title="<?php echo JText::_('COM_KONSAEXP_C_HELP_DESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/phone.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_HELP'); ?> </span></a> </div>
					</div>
 
                    
					<!--div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('administrator/index.php?option=com_konsaexp&view=tools') ?>" title="<?php echo JText::_('COM_KONSAEXP_A_VIEW_TOOLS');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/prune.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_A_VIEW_TOOLS'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('administrator/index.php?option=com_konsaexp&view=stats') ?>" title="<?php echo JText::_('COM_KONSAEXP_STATS_GEN_STATS');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/stats.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_STATS_GEN_STATS'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('administrator/index.php?option=com_konsaexp&view=report') ?>" title="<?php echo JText::_('COM_KONSAEXP_REPORT_SYSTEM');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/report.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_REPORT_SYSTEM'); ?> </span></a> </div>
					</div>
					<div class="icon-container">
						<div class="icon"> <a href="<?php echo JRoute::_('index.php?option=com_plugins&view=plugins&filter_'.(version_compare(JVERSION, '1.6', '>') ? 'folder' : 'type').'=kunena') ?>" title="<?php echo JText::_('COM_KONSAEXP_PLUGINS_MANAGER');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/pluginsmanager.png"  align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_PLUGINS_MANAGER'); ?> </span></a> </div>
					</div>
					<?php if ( $this->config->version_check && (version_compare(JVERSION, '1.6', '<') || JFactory::getUser()->authorise('core.manage', 'com_installer'))) : ?>
					<div class="icon-container">
					<?php
						require_once KPATH_ADMIN.'/liveupdate/liveupdate.php';
						echo LiveUpdate::getIcon();
					?>
					</div>
					<?php endif ?>
					<div class="icon-container">
						<div class="icon"> <a href="http://www.kunena.org" target="_blank" title="<?php echo JText::_('COM_KONSAEXP_C_SUPPORTDESC');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_konsaexp/media/icons/large/support.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_KONSAEXP_C_SUPPORT'); ?> </span></a> </div>
					</div -->
				</div>
			</td>
		</tr>
	</table>
	</div>
	</div>

	<div class="kadmin-footer">
		<?php //echo KunenaVersion::getLongVersionHTML (); ?>
	</div>
</div>