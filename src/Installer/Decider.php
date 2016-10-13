<?php

namespace Tooly\Composer\Installer;

use Composer\IO\IOInterface;
use Tooly\Composer\Installer\Decision\DoReplaceDecision;
use Tooly\Composer\Installer\Decision\FileAlreadyExistDecision;
use Tooly\Composer\Installer\Decision\IsAccessibleDecision;
use Tooly\Composer\Installer\Decision\IsVerifiedDecision;
use Tooly\Composer\Installer\Decision\OnlyDevDecision;
use Tooly\Composer\Installer\Decision\Result;
use Tooly\Composer\Model\Tool;

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
     * @var IOInterface
     */
    private $io;

    /**
     * @param Configuration $configuration
     * @param Helper        $helper
     * @param IOInterface   $io
     */
    public function __construct(Configuration $configuration, Helper $helper, IOInterface $io)
    {
        $this->configuration = $configuration;
        $this->helper = $helper;
        $this->io = $io;
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
            new DoReplaceDecision($this->configuration, $this->helper, $this->io),
        ];
    }
}
