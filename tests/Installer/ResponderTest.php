<?php

namespace ToolInstaller\Tests\Composer\Installer;

use ToolInstaller\Composer\Installer\Responder;

class ResponderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanAddASuccessMessage()
    {
        $responder = $this->getPreparedMock('success', 'foo');
        $responder->addMessage('foo', 'success');
    }

    public function testCanAddATitle()
    {
        $responder = $this->getPreparedMock('title', 'foo');
        $responder->addTitle('foo');
    }

    public function testCanAddASection()
    {
        $responder = $this->getPreparedMock('section', 'foo');
        $responder->addSection('foo');
    }

    public function testCanAddANote()
    {
        $responder = $this->getPreparedMock('note', 'foo');
        $responder->addNote('foo');
    }

    public function testCanAddAComment()
    {
        $responder = $this->getPreparedMock('comment', 'foo');
        $responder->addComment('foo');
    }

    /**
     * @param string $method
     * @param string $parameter
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getPreparedMock($method, $parameter)
    {
        $responder = $this
            ->getMockBuilder(Responder::class)
            ->disableOriginalConstructor()
            ->setMethods(['write'])
            ->getMock();

        $responder
            ->expects($this->once())
            ->method('write')
            ->with(
                $this->equalTo($method),
                $this->equalTo($parameter)
            );

        return $responder;
    }
}
