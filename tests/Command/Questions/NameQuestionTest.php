<?php

namespace ToolInstaller\Tests\Composer\Command\Questions;

use ToolInstaller\Composer\Command\Autocomplete\NameSuggester;
use ToolInstaller\Composer\Command\Questions\NameQuestion;

class NameQuestionTest extends QuestionTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->question = new NameQuestion;
    }

    public function testCanGetAutocompleterValues()
    {
        $autocompleterValues = $this->question->getAutocompleterValues();

        $this->assertTrue(is_array($autocompleterValues));
        $this->assertContains('phpunit', $autocompleterValues);
    }

    public function testCanSaveAutocompleterValue()
    {
        $suggester = $this
            ->getMockBuilder(NameSuggester::class)
            ->disableOriginalConstructor()
            ->getMock();

        $suggester
            ->expects($this->once())
            ->method('has');

        $suggester
            ->expects($this->once())
            ->method('add');

        $question = $this
            ->getMockBuilder(NameQuestion::class)
            ->setMethods(['getSuggester'])
            ->getMock();

        $question
            ->method('getSuggester')
            ->willReturn($suggester);

        $question->saveAutocompleterValues('new-value');
    }

    public function testCanGetQuestion()
    {
        $this->assertEquals('Name of tool/binary to install (example: phpunit): ', $this->question->getQuestion());
    }
}
