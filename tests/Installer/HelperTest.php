<?php

namespace ToolInstaller\Tests\Composer\Installer\Helper;

use Composer\IO\ConsoleIO;
use phpmock\phpunit\PHPMock;
use org\bovigo\vfs\vfsStream;
use ToolInstaller\Composer\Installer\Helper;
use ToolInstaller\Composer\Installer\Helper\Filesystem;
use ToolInstaller\Composer\Installer\Helper\Downloader;
use ToolInstaller\Composer\Installer\Helper\Verifier;

class HelperTest extends \PHPUnit_Framework_TestCase
{
    use PHPMock;

    public function testCanVerifyAFile()
    {
        vfsStream::setup();

        $this
            ->getFunctionMock('ToolInstaller\Composer\Installer', 'sys_get_temp_dir')
            ->expects($this->any())
            ->willReturn('vfs://root/');

        $downloader = $this
            ->getMockBuilder(Downloader::class)
            ->setMethods(['download'])
            ->getMock();

        $downloader
            ->expects($this->any())
            ->method('download')
            ->willReturn('foo');

        $verifier = $this
            ->getMockBuilder(Verifier::class)
            ->setMethods(['checkGPGSignature'])
            ->getMock();

        $verifier
            ->expects($this->exactly(2))
            ->method('checkGPGSignature')
            ->willReturnOnConsecutiveCalls(true, false);

        $helper = $this
            ->getMockBuilder(Helper::class)
            ->setMethods(['getDownloader', 'getVerifier', 'getFilesystem'])
            ->getMock();

        $helper
            ->expects($this->any())
            ->method('getDownloader')
            ->willReturn($downloader);

        $helper
            ->expects($this->any())
            ->method('getVerifier')
            ->willReturn($verifier);

        $helper
            ->expects($this->any())
            ->method('getFilesystem')
            ->willReturn(new Filesystem);

        $this->assertTrue($helper->isVerified('foo.sign', 'foo'));
        $this->assertFalse(file_exists('vfs://root/_tool'));
        $this->assertFalse(file_exists('vfs://root/_tool.sign'));

        $this->assertFalse($helper->isVerified('foo.sign', 'foo'));
        $this->assertFalse(file_exists('vfs://root/_tool'));
        $this->assertFalse(file_exists('vfs://root/_tool.sign'));
    }

    public function testCanCheckIfFileAlreadyExist()
    {
        $filesystem = $this
            ->getMockBuilder(Filesystem::class)
            ->setMethods(['isFileAlreadyExist'])
            ->getMock();

        $filesystem
            ->expects($this->exactly(2))
            ->method('isFileAlreadyExist')
            ->willReturnOnConsecutiveCalls(true, false);

        $verifier = $this
            ->getMockBuilder(Verifier::class)
            ->setMethods(['checkFileSum'])
            ->getMock();

        $verifier
            ->expects($this->exactly(2))
            ->method('checkFileSum')
            ->willReturnOnConsecutiveCalls(true, false);

        $helper = $this
            ->getMockBuilder(Helper::class)
            ->setMethods(['getDownloader', 'getVerifier', 'getFilesystem'])
            ->getMock();

        $helper
            ->expects($this->any())
            ->method('getDownloader')
            ->willReturn(new Downloader);

        $helper
            ->expects($this->any())
            ->method('getVerifier')
            ->willReturn($verifier);

        $helper
            ->expects($this->any())
            ->method('getFilesystem')
            ->willReturn($filesystem);

        $this->assertTrue($helper->isFileAlreadyExist('foo', 'bar'));
        $this->assertFalse($helper->isFileAlreadyExist('foo', 'bar'));
    }

    public function testCanGetDownloader()
    {
        $helper = new Helper;
        $this->assertInstanceOf(Downloader::class, $helper->getDownloader());
    }

    public function testCanGetVerifier()
    {
        $helper = new Helper;
        $this->assertInstanceOf(Verifier::class, $helper->getVerifier());
    }

    public function testCanGetFilesystemm()
    {
        $helper = new Helper;
        $this->assertInstanceOf(Filesystem::class, $helper->getFilesystem());
    }

    public function testCanGetIO()
    {
        $helper = new Helper;
        $this->assertInstanceOf(ConsoleIO::class, $helper->getIO());
    }

    public function testCanGetAbsolutePathToFile()
    {
        $helper = new Helper;
        $this->assertEquals(
            realpath(__DIR__ . '/../../composer.json'),
            $helper->getAbsolutePathToFile(__DIR__ . '/../../', 'composer.json')
        );
    }
}
