<?php

namespace Tooly\Composer\Generator\Questions;

use Symfony\Component\Console\Question\ConfirmationQuestion;

class OnlyDevQuestion extends ConfirmationQuestion
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct('Only dev:', true, '/^y/i');
    }
}
