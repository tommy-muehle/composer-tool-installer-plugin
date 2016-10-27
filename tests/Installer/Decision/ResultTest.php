<?php

namespace ToolInstaller\Tests\Composer\Installer\Decision;

use ToolInstaller\Composer\Installer\Decision\Result;

class ResultTest extends \PHPUnit_Framework_TestCase
{
    public function testCanMarkResultFalse()
    {
        $result = new Result;
        $this->assertTrue($result->isSuccessful());

        $result->markFalse();
        $this->assertFalse($result->isSuccessful());
    }

    public function testCanSetAReason()
    {
        $result = new Result;
        $this->assertNull($result->getReason());

        $result->setReason('foo');
        $this->assertEquals('foo', $result->getReason());
    }
}
