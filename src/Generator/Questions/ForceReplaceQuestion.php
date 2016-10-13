<?php

namespace Tooly\Composer\Generator\Questions;

use Symfony\Component\Console\Question\ConfirmationQuestion;

class ForceReplaceQuestion  extends ConfirmationQuestion
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('Force replace:', false, '/^y/i');
    }
}
