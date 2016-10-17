<?php

namespace ToolInstaller\Composer\Command\Questions;

use Symfony\Component\Console\Question\ConfirmationQuestion;

class OnlyDevQuestion extends ConfirmationQuestion
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('Only dev (default: yes): ', true, '/^y/i');
    }
}
