<?php

namespace ToolInstaller\Composer\Installer\Decision;

use ToolInstaller\Composer\Model\Tool;

/**
 * @package ToolInstaller\Script\Decision
 */
class OnlyDevDecision extends AbstractDecision
{
    /**
     * @param Tool $tool
     *
     * @return bool
     */
    public function canProceed(Tool $tool)
    {
        if (false === $this->configuration->isDevMode() && true === $tool->isOnlyDev()) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return '<warning>... skipped! Only installed in Dev mode.</warning>';
    }
}
