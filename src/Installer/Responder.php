<?php

namespace ToolInstaller\Composer\Installer;

use Composer\IO\IOInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class Responder
{
    /**
     * @var IOInterface
     */
    private $composerIO;

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @param IOInterface $composerIO
     */
    public function __construct(IOInterface $composerIO)
    {
        $this->composerIO = $composerIO;
        $this->io = new SymfonyStyle(new ArgvInput, new ConsoleOutput);
    }

    /**
     * @param string $message
     */
    public function addTitle($message)
    {
        $this->write('title', $message);
    }

    /**
     * @param string $message
     */
    public function addSection($message)
    {
        $this->write('section', $message);
    }

    /**
     * @param string $message
     */
    public function addNote($message)
    {
        $this->write('note', $message);
    }

    /**
     * @param string $message
     */
    public function addComment($message)
    {
        $this->write('comment', $message);
    }

    /**
     * @param string $message
     * @param string $level
     */
    public function addMessage($message, $level = 'info')
    {
        $method = 'text';

        if ('warning' === $level) {
            $method = 'warning';
        }

        if ('error' === $level) {
            $method = 'error';
        }

        if ('success' === $level) {
            $method = 'success';
        }

        $this->write($method, $message);
    }

    /**
     * @param string $method
     * @param string $message
     */
    protected function write($method, $message)
    {
        $this->io->$method($message);
    }
}
