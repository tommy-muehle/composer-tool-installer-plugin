<?php

namespace ToolInstaller\Tests\Composer\Installer\Helper;

use Composer\Composer;
use Composer\Config;
use Composer\Package\Package;
use ToolInstaller\Composer\Installer\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testIfNoToolsSetEmptyToolSetIsGiven()
    {
        $composer = $this->getPreparedComposerInstance([], '');
        $configuration = new Configuration($composer);

        $this->assertCount(0, $configuration->getTools());
    }

    public function testCanGetCorrectToolSet()
    {
        $extra = [
            'tools' => [
                'foo' => [
                    'url' => 'foo'
                ]
            ]
        ];

        $composer = $this->getPreparedComposerInstance($extra, '');
        $configuration = new Configuration($composer);

        $this->assertCount(1, $configuration->getTools());
    }

    public function testCanCheckDevMode()
    {
        $composer = $this->getPreparedComposerInstance([], '');
        $configuration = new Configuration($composer);

        $this->assertTrue($configuration->isDevMode());
    }

    public function testCanSetDevMode()
    {
        $composer = $this->getPreparedComposerInstance([], '');

        $configuration = new Configuration($composer);
        $configuration->setNoDev();

        $this->assertFalse($configuration->isDevMode());
    }

    public function testCanCheckInteractiveMode()
    {
        $composer = $this->getPreparedComposerInstance([], '');
        $configuration = new Configuration($composer);

        $this->assertTrue($configuration->isInteractiveMode());
    }

    public function testCanSetInteractiveMode()
    {
        $composer = $this->getPreparedComposerInstance([], '');

        $configuration = new Configuration($composer);
        $configuration->setNonInteractive();

        $this->assertFalse($configuration->isInteractiveMode());
    }

    public function testCanGetCorrectComposerBinDirectory()
    {
        $binDir = __DIR__ . '/../../vendor/bin';

        $composer = $this->getPreparedComposerInstance([], $binDir);
        $configuration = new Configuration($composer);

        $this->assertEquals($binDir, $configuration->getComposerBinDirectory());
    }

    public function testCanGetCorrectBinDir()
    {
        $composer = $this->getPreparedComposerInstance([], '');
        $configuration = new Configuration($composer);

        $this->assertEquals(realpath(__DIR__ . '/../../bin'), $configuration->getBinDirectory());
    }

    /**
     * @param mixed $extra
     * @param mixed $binDir
     *
     * @return Composer
     */
    private function getPreparedComposerInstance($extra, $binDir)
    {
        $package = $this
            ->getMockBuilder(Package::class)
            ->disableOriginalConstructor()
            ->getMock();

        $package
            ->expects($this->once())
            ->method('getExtra')
            ->willReturn($extra);

        $configuration = $this
            ->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $configuration
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('bin-dir'))
            ->willReturn($binDir);

        $composer = $this
            ->getMockBuilder(Composer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $composer
            ->expects($this->once())
            ->method('getPackage')
            ->willReturn($package);

        $composer
            ->expects($this->once())
            ->method('getConfig')
            ->willReturn($configuration);

        return $composer;
    }
}
