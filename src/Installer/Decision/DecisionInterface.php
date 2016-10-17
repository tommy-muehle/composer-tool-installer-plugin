<?php

namespace ToolInstaller\Composer\Installer\Decision;

use ToolInstaller\Composer\Model\Tool;

/**
 * @package ToolInstaller\Script\Decision
 */
interface DecisionInterface
{
    /**
     * @param Tool $tool
     *
     * @return bool
     */
    public function canProceed(Tool $tool);

    /**
     * @return string
     */
    public function getReason();
}
