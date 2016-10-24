<?php

namespace ToolInstaller\Tests\Composer\Command\Questions;

use ToolInstaller\Composer\Command\Questions\AbstractQuestion;

abstract class QuestionTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractQuestion
     */
    protected $question;

    abstract public function testCanGetQuestion();
}
