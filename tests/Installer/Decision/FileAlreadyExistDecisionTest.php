<?php

namespace ToolInstaller\Tests\Composer\Installer\Decision;

use ToolInstaller\Composer\Model\Tool;
use ToolInstaller\Composer\Installer\Decision\FileAlreadyExistDecision;

class FileAlreadyExistDecisionTest extends DecisionTestCase
{
    public function testIfFileNotAlreadyExistReturnsTrue()
    {
        $this->helper
            ->expects($this->once())
            ->method('isFileAlreadyExist')
            ->willReturn(false);

        $tool = $this
            ->getMockBuilder(Tool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $decision = new FileAlreadyExistDecision($this->configuration, $this->helper);
        $this->assertTrue($decision->canProceed($tool));
    }

    public function testIfFileAlreadyExistReturnsFalse()
    {
        $this->helper
            ->expects($this->once())
            ->method('isFileAlreadyExist')
            ->willReturn(true);

        $tool = $this
            ->getMockBuilder(Tool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $decision = new FileAlreadyExistDecision($this->configuration, $this->helper);
        $this->assertFalse($decision->canProceed($tool));
    }

    public function testCanGetReason()
    {
        $decision = new FileAlreadyExistDecision($this->configuration, $this->helper);
        $this->assertRegExp('/success/', $decision->getReason());
    }
}
