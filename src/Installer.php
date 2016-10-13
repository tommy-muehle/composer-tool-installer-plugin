<?php

namespace Tooly\Composer;

use Composer\Script\Event;
use Tooly\Composer\Installer\Helper;
use Tooly\Composer\Installer\Configuration;
use Tooly\Composer\Installer\Decider;
use Tooly\Composer\Installer\Mode;
use Tooly\Composer\Model\Tool;

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
        $mode = new Mode;

        if (false === $event->isDevMode()) {
            $mode->setNoDev();
        }

        if (false === $event->getIO()->isInteractive()) {
            $mode->setNonInteractive();
        }

        $this->configuration  = new Configuration($event->getComposer(), $mode);
        $this->helper = new Helper;
        $this->io = $event->getIO();
        $this->decider = new Decider($this->configuration, $this->helper, $this->io);
    }

    public function cleanUp()
    {
        $this->removeFromDir(
            $this->configuration->getComposerBinDirectory()
        );

        $this->removeFromDir(
            $this->configuration->getBinDirectory(),
            array_keys($this->configuration->getTools())
        );
    }

    public function process()
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

            $this->io->write(sprintf(
                '<info>File "%s" successfully downloaded!</info>',
                basename($filename)
            ));
        }
    }

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
    }

    /**
     * @param string $dir
     * @param array  $excludeToolNames
     */
    private function removeFromDir($dir, array $excludeToolNames = [])
    {
        foreach (scandir($dir) as $entry) {
            $path = $dir . DIRECTORY_SEPARATOR . $entry;

            if (false === strpos($path, '.phar')) {
                continue;
            }

            if (true === in_array(basename($entry, '.phar'), $excludeToolNames)) {
                continue;
            }

            $this->helper->getFilesystem()->remove($path);
        }
    }
}
