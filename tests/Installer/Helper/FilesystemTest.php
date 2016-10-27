<?php

namespace ToolInstaller\Tests\Composer\Installer\Helper;

use org\bovigo\vfs\vfsStream;
use phpmock\phpunit\PHPMock;
use ToolInstaller\Composer\Installer\Helper\Filesystem;

class FilesystemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $testDirectory;

    /**
     * @var string
     */
    private $testFile;

    public function setUp()
    {
        $this->filesystem = new Filesystem;
        $this->testDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test';
        $this->testFile = $this->testDirectory . DIRECTORY_SEPARATOR . 'file';
    }

    public function tearDown()
    {
        if (is_dir($this->testDirectory)) {
            $this->filesystem->removeDirectory($this->testDirectory);
        }
    }

    public function testCanRelativeSymlinkAFile()
    {
        $symlink = $this->testDirectory . DIRECTORY_SEPARATOR . '/foo/symlink';

        $this->assertTrue($this->filesystem->symlinkFile($this->testFile, $symlink));
        $this->assertNotEquals('/', substr(readlink($symlink), '0', 1));
    }
}
