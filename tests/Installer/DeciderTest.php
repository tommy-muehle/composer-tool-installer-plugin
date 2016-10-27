<?php

namespace ToolInstaller\Tests\Composer\Installer;

use ToolInstaller\Composer\Installer\Decider;
use ToolInstaller\Composer\Installer\Decision\Result;
use ToolInstaller\Composer\Model\Tool;
use ToolInstaller\Tests\Composer\Fixture\Installer\Decision\ReturnFalseDecision;

class DeciderTest extends \PHPUnit_Framework_TestCase
{
    public function testDecisionResultIsDefaultTrue()
    {
        $decider = new Decider([]);
        $result = $decider->canInstall(new Tool('name', 'url'));

        $this->assertInstanceOf(Result::class, $result);
        $this->assertTrue($result->isSuccessful());
    }

    public function testDecisionCanMarkResultAsFalse()
    {
        $decider = new Decider([new ReturnFalseDecision]);
        $result = $decider->canInstall(new Tool('name', 'url'));

        $this->assertInstanceOf(Result::class, $result);
        $this->assertFalse($result->isSuccessful());
    }
}
