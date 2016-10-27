<?php

namespace ToolInstaller\Tests\Composer\Fixture\Installer\Decision;

use ToolInstaller\Composer\Installer\Decision\DecisionInterface;
use ToolInstaller\Composer\Model\Tool;

class ReturnFalseDecision implements DecisionInterface
{
    public function canProceed(Tool $tool)
    {
        return false;
    }

    public function getReason()
    {
        return 'Iam a false stub';
    }
}
