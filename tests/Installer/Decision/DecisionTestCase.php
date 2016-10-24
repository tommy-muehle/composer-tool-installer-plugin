<?php

namespace ToolInstaller\Tests\Composer\Installer\Decision;

use ToolInstaller\Composer\Installer\Configuration;
use ToolInstaller\Composer\Installer\Helper;

abstract class DecisionTestCase extends \PHPUnit_Framework_TestCase
{
    protected $helper;

    protected $configuration;

    public function setUp()
    {
        $this->helper = $this
            ->getMockBuilder(Helper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configuration = $this
            ->getMockBuilder(Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function assertOutput()
    {

    }
}
