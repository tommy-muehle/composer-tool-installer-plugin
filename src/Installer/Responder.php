<?php

namespace ToolInstaller\Composer\Installer;

use Composer\IO\IOInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class Responder
{
    private $composerIO;

    private $io;

    public function __construct(IOInterface $composerIO)
    {
        $this->composerIO = $composerIO;
        $this->io = new SymfonyStyle(new ArgvInput, new ConsoleOutput);
    }

    public function addTitle($message)
    {
        $this->io->title($message);
    }

    public function addSection($message)
    {
        $this->io->section($message);
    }

    public function addNote($message)
    {
        $this->io->note($message);
    }

    public function addComment($message)
    {
        $this->io->comment($message);
    }

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

        $this->io->$method($message);
    }
}
