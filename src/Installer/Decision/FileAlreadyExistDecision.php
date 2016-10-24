<?php

namespace ToolInstaller\Composer\Installer\Decision;

use ToolInstaller\Composer\Model\Tool;

/**
 * @package ToolInstaller\Script\Decision
 */
class FileAlreadyExistDecision extends AbstractDecision
{
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

        if (false === $this->helper->isFileAlreadyExist($filename, $tool->getUrl())) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return '<success>File already exists in the given version.</success>';
    }
}
