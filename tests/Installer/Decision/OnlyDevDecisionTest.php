<?php

namespace ToolInstaller\Tests\Composer\Installer\Decision;

use ToolInstaller\Composer\Model\Tool;
use ToolInstaller\Composer\Installer\Decision\OnlyDevDecision;

class OnlyDevDecisionTest extends DecisionTestCase
{
    public function testOnlyDevToolInNonDevModeReturnsFalse()
    {
        $helper = clone $this->helper;
        $configuration = clone $this->configuration;

        $configuration
            ->expects($this->once())
            ->method('isDevMode')
            ->willReturn(false);

        $tool = $this
            ->getMockBuilder(Tool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tool
            ->expects($this->once())
            ->method('isOnlyDev')
            ->willReturn(true);

        $decision = new OnlyDevDecision($configuration, $helper);
        $this->assertFalse($decision->canProceed($tool));
    }

    public function testNonOnlyDevToolInNonDevModeReturnsTrue()
    {
        $helper = clone $this->helper;
        $configuration = clone $this->configuration;

        $configuration
            ->expects($this->once())
            ->method('isDevMode')
            ->willReturn(false);

        $tool = $this
            ->getMockBuilder(Tool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tool
            ->expects($this->once())
            ->method('isOnlyDev')
            ->willReturn(false);

        $decision = new OnlyDevDecision($configuration, $helper);
        $this->assertTrue($decision->canProceed($tool));
    }

    public function testNonOnlyDevToolInDevModeReturnsTrue()
    {
        $helper = clone $this->helper;
        $configuration = clone $this->configuration;

        $configuration
            ->expects($this->once())
            ->method('isDevMode')
            ->willReturn(true);

        $tool = $this
            ->getMockBuilder(Tool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tool
            ->expects($this->never())
            ->method('isOnlyDev');

        $decision = new OnlyDevDecision($configuration, $helper);
        $this->assertTrue($decision->canProceed($tool));
    }

    public function testCanGetReason()
    {
        $decision = new OnlyDevDecision($this->configuration, $this->helper);
        $this->assertRegExp('/warning/', $decision->getReason());
    }
}
