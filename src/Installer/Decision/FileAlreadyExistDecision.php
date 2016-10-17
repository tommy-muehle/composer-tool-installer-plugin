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
        if (false === $this->helper->isFileAlreadyExist($tool->getFilename(), $tool->getUrl())) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return '<info>File already exists in the given version.</info>';
    }
}
