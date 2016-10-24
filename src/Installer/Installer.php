<?php

namespace ToolInstaller\Composer\Installer;

use Composer\Script\Event;
use ToolInstaller\Composer\Installer\Helper;
use ToolInstaller\Composer\Installer\Configuration;
use ToolInstaller\Composer\Installer\Decider;
use ToolInstaller\Composer\Model\Tool;
use ToolInstaller\Composer\Installer\Responder;

class Installer
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var Responder
     */
    private $responder;

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
        $io = $event->getIO();
        $configuration = new Configuration($event->getComposer());

        if (false === $event->isDevMode()) {
            $configuration->setNoDev();
        }

        if (false === $io->isInteractive()) {
            $configuration->setNonInteractive();
        }

        $this->configuration  = $configuration;
        $this->helper = new Helper;
        $this->responder = new Responder($io);
        $this->decider = new Decider($this->configuration, $this->helper);

        $this->responder->addTitle('Tool-Installer');
        $this->responder->addNote(
            'Please report any problems or feature-requests on: https://github.com/tommy-muehle/composer-tool-installer-plugin'
        );
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
            $this->responder->addSection(sprintf('Install "%s" from "%s" ...', $tool->getName(), $tool->getUrl()));
            $result = $this->decider->canInstall($tool);

            if (false === $result->isSuccessful()) {
                $this->throwReason($result->getReason());
                continue;
            }

            $this->downloadFile($tool->getUrl(), $tool->getFilename());

            if (true === $tool->hasKeyFile()) {
                $this->downloadFile($tool->getKeyUrl(), $tool->getKeyFilename());
            }
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
                return $this;
            }

            $this->helper->getFilesystem()->symlinkFile(
                $this->configuration->getBinDirectory() . DIRECTORY_SEPARATOR . $tool->getFilename(),
                $this->configuration->getComposerBinDirectory(). DIRECTORY_SEPARATOR . $tool->getFilename()
            );
        }

        return $this;
    }

    /**
     * @param string $url
     * @param string $file
     */
    private function downloadFile($url, $file)
    {
        $data = $this->helper->getDownloader()->download($url);
        $filename = $this->configuration->getBinDirectory() . DIRECTORY_SEPARATOR . $file;

        $this->helper->getFilesystem()->createFile($filename, $data);
        $this->responder->addMessage(sprintf('File "%s" successfully downloaded!', basename($filename)), 'success');
    }

    /**
     * @param string $message
     */
    private function throwReason($message)
    {
        preg_match('/<(.*?)>/', $message, $matches);
        $message = preg_replace('/<(.*?)>/', '', $message);

        $this->responder->addMessage($message, $matches[1]);
    }
}
