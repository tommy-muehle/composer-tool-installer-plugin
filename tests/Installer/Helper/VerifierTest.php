<?php

namespace ToolInstaller\Tests\Composer\Installer\Helper;

use TM\GPG\Verification\Exception\VerificationException;
use ToolInstaller\Composer\Installer\Helper\Verifier;
use TM\GPG\Verification\Verifier as GPGVerifier;

class VerifierTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCheckIfFileSumsAreEqual()
    {
        $verifier = new Verifier;
        $this->assertTrue($verifier->checkFileSum(
            __DIR__ . '/../../../composer.json',
            __DIR__ . '/../../../composer.json'
        ));
    }

    public function testNotExistTargetFileReturnsFalse()
    {
        $verifier = new Verifier;
        $this->assertFalse($verifier->checkFileSum(
            __DIR__ . '/../../../composer.json',
            __DIR__ . '/../../../composer.lock'
        ));
    }

    public function testIfNoVerifierGivenSignatureCheckReturnsTrue()
    {
        $verifier = new Verifier;
        $this->assertTrue($verifier->checkGPGSignature('foo.sign', 'foo'));
    }

    public function testInvalidSignatureReturnsFalse()
    {
        $gpgVerifier = $this
            ->getMockBuilder(GPGVerifier::class)
            ->disableOriginalConstructor()
            ->setMethods(['verify'])
            ->getMock();

        $gpgVerifier
            ->method('verify')
            ->will($this->throwException(new VerificationException));

        $verifier = new Verifier($gpgVerifier);
        $this->assertFalse($verifier->checkGPGSignature('foo.sign', 'foo'));
    }

    public function testValidSignatureReturnsTrue()
    {
        $gpgVerifier = $this
            ->getMockBuilder(GPGVerifier::class)
            ->disableOriginalConstructor()
            ->setMethods(['verify'])
            ->getMock();

        $gpgVerifier
            ->method('verify')
            ->willReturnSelf();

        $verifier = new Verifier($gpgVerifier);
        $this->assertTrue($verifier->checkGPGSignature('foo.sign', 'foo'));
    }
}
