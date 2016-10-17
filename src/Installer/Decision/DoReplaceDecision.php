<?php

namespace ToolInstaller\Composer\Installer\Decision;

use Composer\IO\IOInterface;
use ToolInstaller\Composer\Model\Tool;
use ToolInstaller\Composer\Installer\Configuration;
use ToolInstaller\Composer\Installer\Helper;

/**
 * @package ToolInstaller\Script\Decision
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
     */
    public function __construct(Configuration $configuration, Helper $helper)
    {
        $this->io = $helper->getIO();

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
