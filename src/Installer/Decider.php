<?php

namespace ToolInstaller\Composer\Installer;

use ToolInstaller\Composer\Installer\Decision\DoReplaceDecision;
use ToolInstaller\Composer\Installer\Decision\FileAlreadyExistDecision;
use ToolInstaller\Composer\Installer\Decision\IsAccessibleDecision;
use ToolInstaller\Composer\Installer\Decision\IsVerifiedDecision;
use ToolInstaller\Composer\Installer\Decision\OnlyDevDecision;
use ToolInstaller\Composer\Installer\Decision\Result;
use ToolInstaller\Composer\Model\Tool;

class Decider
{
    /**
     * @var array
     */
    private $decisions = [];

    /**
     * @param array $decisions
     */
    public function __construct(array $decisions)
    {
        $this->decisions = $decisions;
    }

    /**
     * @param Tool $tool
     *
     * @return Result
     */
    public function canInstall(Tool $tool)
    {
        $result = new Result;

        foreach ($this->decisions as $decision) {
            if (true === $decision->canProceed($tool)) {
                continue;
            }

            $result->markFalse();
            $result->setReason($decision->getReason());

            break;
        }

        return $result;
    }
}
