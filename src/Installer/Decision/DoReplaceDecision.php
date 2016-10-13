<?php

namespace Tooly\Composer\Installer\Decision;

use Composer\IO\IOInterface;
use Tooly\Composer\Model\Tool;
use Tooly\Composer\Installer\Configuration;
use Tooly\Composer\Installer\Helper;

/**
 * @package Tooly\Script\Decision
 */
class DoReplaceDecision extends AbstractDecision
{
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
        $this->io = $io;

        parent::__construct($configuration, $helper);
    }

    /**
     * @param Tool $tool
     *
     * @return bool
     */
    public function canProceed(Tool $tool)
    {
        if (false === $this->helper->getFilesystem()->isFileAlreadyExist($tool->getFilename())) {
            return true;
        }

        $doReplace = $tool->forceReplace();

        if (true === $this->configuration->isInteractiveMode()) {
            $this->io->write('<comment>Checksums are not equal!</comment>');
            $this->io->write(sprintf(
                '<comment>Do you want to overwrite the existing file "%s"?</comment>',
                $tool->getName()
            ));

            $doReplace = $this->io->askConfirmation('<question>[yes] or [no]?</question>', false);
        }

        return $doReplace;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return '<info>No replace selected. Skipped.</info>';
    }
}
