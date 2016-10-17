<?php

namespace ToolInstaller\Composer\Installer;

use Composer\IO\IOInterface;
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
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * @param Configuration $configuration
     * @param Helper        $helper
     */
    public function __construct(Configuration $configuration, Helper $helper)
    {
        $this->configuration = $configuration;
        $this->helper = $helper;
    }

    /**
     * @param Tool $tool
     *
     * @return Result
     */
    public function canInstall(Tool $tool)
    {
        $result = new Result;

        foreach ($this->getDecisions() as $decision) {
            if (true === $decision->canProceed($tool)) {
                continue;
            }

            $result->markFalse();
            $result->setReason($decision->getReason());

            break;
        }

        return $result;
    }

    /**
     * Each decision can interrupt the download of a tool.
     *
     * @return array
     */
    private function getDecisions()
    {
        return [
            new OnlyDevDecision($this->configuration, $this->helper),
            new IsAccessibleDecision($this->configuration, $this->helper),
            new FileAlreadyExistDecision($this->configuration, $this->helper),
            new IsVerifiedDecision($this->configuration, $this->helper),
            new DoReplaceDecision($this->configuration, $this->helper),
        ];
    }
}
