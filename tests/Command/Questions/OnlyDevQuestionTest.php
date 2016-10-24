<?php

namespace ToolInstaller\Tests\Composer\Command\Questions;

use Symfony\Component\Console\Question\ConfirmationQuestion;
use ToolInstaller\Composer\Command\Questions\AbstractQuestion;
use ToolInstaller\Composer\Command\Questions\OnlyDevQuestion;

class OnlyDevQuestionTest extends QuestionTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->question = new OnlyDevQuestion;
    }

    public function testCanGetQuestion()
    {
        $this->assertEquals('Only dev (default: yes): ', $this->question->getQuestion());
    }

    public function testIsConfirmationQuestion()
    {
        $this->assertInstanceOf(ConfirmationQuestion::class, $this->question);
    }

    public function testDefaultIsTrue()
    {
        $this->assertTrue($this->question->getDefault());
    }
}
