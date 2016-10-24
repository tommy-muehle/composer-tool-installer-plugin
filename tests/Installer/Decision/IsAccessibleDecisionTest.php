<?php

namespace ToolInstaller\Tests\Composer\Installer\Decision;

use ToolInstaller\Composer\Installer\Decision\IsAccessibleDecision;
use ToolInstaller\Composer\Installer\Helper\Downloader;
use ToolInstaller\Composer\Model\Tool;

class IsAccessibleDecisionTest extends DecisionTestCase
{
    public function testNotAccessibleToolUrlReturnsFalse()
    {
        $downloader = $this
            ->getMockBuilder(Downloader::class)
            ->getMock();

        $downloader
            ->expects($this->once())
            ->method('isAccessible')
            ->willReturn(false);

        $this->helper
            ->expects($this->once())
            ->method('getDownloader')
            ->willReturn($downloader);

        $decision = new IsAccessibleDecision($this->configuration, $this->helper);
        $this->assertFalse($decision->canProceed(new Tool('tool', '')));
    }

    public function testEmptySignUrlReturnsTrue()
    {
        $downloader = $this
            ->getMockBuilder(Downloader::class)
            ->getMock();

        $downloader
            ->expects($this->once())
            ->method('isAccessible')
            ->willReturn(true);

        $this->helper
            ->expects($this->once())
            ->method('getDownloader')
            ->willReturn($downloader);

        $decision = new IsAccessibleDecision($this->configuration, $this->helper);
        $this->assertTrue($decision->canProceed(new Tool('tool', '')));
    }

    public function testNotAccessibleToolSignUrlReturnsFalse()
    {
        $downloader = $this
            ->getMockBuilder(Downloader::class)
            ->getMock();

        $downloader
            ->expects($this->exactly(2))
            ->method('isAccessible')
            ->will($this->onConsecutiveCalls(true, false));

        $this->helper
            ->expects($this->exactly(2))
            ->method('getDownloader')
            ->willReturn($downloader);

        $decision = new IsAccessibleDecision($this->configuration, $this->helper);
        $this->assertFalse($decision->canProceed(new Tool('tool', '', 'sign-url')));
    }

    public function testAccessibleUrlsWillReturnTrue()
    {
        $downloader = $this
            ->getMockBuilder(Downloader::class)
            ->getMock();

        $downloader
            ->expects($this->exactly(2))
            ->method('isAccessible')
            ->will($this->onConsecutiveCalls(true, true));

        $this->helper
            ->expects($this->exactly(2))
            ->method('getDownloader')
            ->willReturn($downloader);

        $decision = new IsAccessibleDecision($this->configuration, $this->helper);
        $this->assertTrue($decision->canProceed(new Tool('tool', '', 'sign-url')));
    }

    public function testCanGetReason()
    {
        $decision = new IsAccessibleDecision($this->configuration, $this->helper);
        $this->assertRegExp('/error/', $decision->getReason());
    }
}
