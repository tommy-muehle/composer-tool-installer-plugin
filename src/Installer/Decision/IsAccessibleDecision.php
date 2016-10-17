<?php

namespace ToolInstaller\Composer\Installer\Decision;

use ToolInstaller\Composer\Model\Tool;

/**
 * @package ToolInstaller\Script\Decision
 */
class IsAccessibleDecision extends AbstractDecision
{
    /**
     * @param Tool $tool
     *
     * @return bool
     */
    public function canProceed(Tool $tool)
    {
        if (false === $this->helper->getDownloader()->isAccessible($tool->getUrl())) {
            return false;
        }

        if (empty($tool->getSignUrl())) {
            return true;
        }

        if (false === $this->helper->getDownloader()->isAccessible($tool->getSignUrl())) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return '<error>At least one given URL are not accessible!</error>';
    }
}
