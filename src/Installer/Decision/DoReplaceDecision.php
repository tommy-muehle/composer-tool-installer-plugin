<?php

namespace ToolInstaller\Composer\Installer\Decision;

use Composer\IO\ConsoleIO;
use ToolInstaller\Composer\Installer\Configuration;
use ToolInstaller\Composer\Installer\Helper;
use ToolInstaller\Composer\Model\Tool;

/**
 * @package ToolInstaller\Script\Decision
 */
class DoReplaceDecision extends AbstractDecision
{
    /**
     * @var ConsoleIO
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
        $filename = $this->helper->getAbsolutePathToFile(
            $this->configuration->getBinDirectory(),
            $tool->getFilename()
        );

        if (false === $this->helper->getFilesystem()->isFileAlreadyExist($filename)) {
            return true;
        }

        $doReplace = $tool->forceReplace();

        if (true === $this->configuration->isInteractiveMode()) {
            $this->io->warning('Checksums are not equal!');
            $this->io->warning(sprintf('Do you want to overwrite the existing file "%s"?', $tool->getFilename()));

            $doReplace = $this->io->askConfirmation('[yes] or [no]?', false);
        }

        return $doReplace;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return '<success>No replace selected. Skipped.</success>';
    }
}
