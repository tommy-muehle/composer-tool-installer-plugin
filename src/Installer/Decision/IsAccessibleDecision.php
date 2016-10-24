<?php

namespace ToolInstaller\Composer\Installer\Decision;

use ToolInstaller\Composer\Model\Tool;

/**
 * @package ToolInstaller\Script\Decision
 */
class IsAccessibleDecision extends AbstractDecision
{
    /**
     * @var string
     */
    private $notAccessibleUrl;

    /**
     * @param Tool $tool
     *
     * @return bool
     */
    public function canProceed(Tool $tool)
    {
        if (false === $this->helper->getDownloader()->isAccessible($tool->getUrl())) {
            $this->notAccessibleUrl = $tool->getUrl();
            return false;
        }

        if (empty($tool->getSignUrl())) {
            return true;
        }

        if (false === $this->helper->getDownloader()->isAccessible($tool->getSignUrl())) {
            $this->notAccessibleUrl = $tool->getSignUrl();
            return false;
        }

        if (empty($tool->getKeyUrl())) {
            return true;
        }

        if (false === $this->helper->getDownloader()->isAccessible($tool->getKeyUrl())) {
            $this->notAccessibleUrl = $tool->getKeyUrl();
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return sprintf('<error>At least the URL "%s" are not accessible!</error>', $this->notAccessibleUrl);
    }
}
