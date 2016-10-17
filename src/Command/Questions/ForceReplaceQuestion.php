<?php

namespace ToolInstaller\Composer\Command\Questions;

use Symfony\Component\Console\Question\ConfirmationQuestion;

class ForceReplaceQuestion  extends ConfirmationQuestion
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('Force replace (default: no): ', false, '/^y/i');
    }
}
