<?php

namespace ToolInstaller\Tests\Composer\Installer\Helper;

use phpmock\phpunit\PHPMock;
use ToolInstaller\Composer\Installer\Helper\Downloader;

class DownloaderTest extends \PHPUnit_Framework_TestCase
{
    use PHPMock;

    public function testAccessibleTestWorksCorrect()
    {
        $downloader = new Downloader;

        $this->assertFalse($downloader->isAccessible('foo'));
        $this->assertTrue($downloader->isAccessible('https://github.com/tommy-muehle/tooly-composer-script/blob/master/README.md'));
    }

    public function testCanDownloadContentFromUrl()
    {
        $downloader = new Downloader;

        $this->assertRegExp(
            '/tooly-composer-script/',
            $downloader->download('https://github.com/tommy-muehle/tooly-composer-script/blob/master/README.md')
        );
    }
}
