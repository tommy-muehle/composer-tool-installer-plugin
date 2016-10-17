<?php

namespace ToolInstaller\Composer\Installer;

use Composer\Script\Event;
use ToolInstaller\Composer\Installer\Helper;
use ToolInstaller\Composer\Installer\Configuration;
use ToolInstaller\Composer\Installer\Decider;
use ToolInstaller\Composer\Model\Tool;

class Installer
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var \Composer\IO\IOInterface
     */
    private $io;

    /**
     * @var Decider
     */
    private $decider;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $configuration = new Configuration($event->getComposer());
        $io = $event->getIO();

        if (false === $event->isDevMode()) {
            $configuration->setNoDev();
        }

        if (false === $io->isInteractive()) {
            $configuration->setNonInteractive();
        }

        $this->configuration  = $configuration;
        $this->io = $io;
        $this->helper = new Helper;
        $this->decider = new Decider($this->configuration, $this->helper);
    }

    /**
     * @todo Documentation
     */
    public function prepare()
    {
        if (false === is_dir($this->configuration->getBinDirectory())) {
            mkdir($this->configuration->getBinDirectory());
        }

        return $this;
    }

    /**
     * @todo Documentation
     */
    public function cleanUp()
    {
        $this->helper->getFilesystem()->removeFromDir(
            $this->configuration->getComposerBinDirectory()
        );

        $this->helper->getFilesystem()->removeFromDir(
            $this->configuration->getBinDirectory(),
            array_keys($this->configuration->getTools())
        );

        return $this;
    }

    /**
     * @todo Documentation
     */
    public function download()
    {
        /* @var $tool Tool */
        foreach ($this->configuration->getTools() as $tool) {
            $this->io->write(sprintf('<comment>Process tool "%s" ...</comment>', $tool->getName()));
            $result = $this->decider->canInstall($tool);

            if (false === $result->isSuccessful()) {
                $this->io->write($result->getReason());
                continue;
            }

            $data = $this->helper->getDownloader()->download($tool->getUrl());
            $filename = $tool->getFilename();

            $this->helper->getFilesystem()->createFile($filename, $data);
            $this->io->write(sprintf('<info>File "%s" successfully downloaded!</info>', basename($filename)));
        }

        return $this;
    }

    /**
     * @todo Documentation
     */
    public function symlink()
    {
        /* @var $tool Tool */
        foreach ($this->configuration->getTools() as $tool) {
            if (true === $tool->isOnlyDev() && false === $this->configuration->isDevMode()) {
                return;
            }

            $filename = $tool->getFilename();

            $composerDir = $this->configuration->getComposerBinDirectory();
            $composerPath = $composerDir . DIRECTORY_SEPARATOR . basename($filename);

            $this->helper->getFilesystem()->symlinkFile($filename, $composerPath);
        }

        return $this;
    }
}
