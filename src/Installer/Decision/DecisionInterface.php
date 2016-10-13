<?php

namespace Tooly\Composer\Installer\Decision;

use Tooly\Composer\Model\Tool;

/**
 * @package Tooly\Script\Decision
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
