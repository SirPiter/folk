<?php

defined('_JEXEC') or die;

class AtsViewCpanel extends F0FViewHtml
{
    protected function onBrowse($tpl = null)
    {
        parent::onBrowse($tpl);

        // Collect information about the site
        $this->statsIframe = F0FModel::getTmpInstance('Stats', 'AtsModel')->collectStatistics(true);

        return true;
    }
}