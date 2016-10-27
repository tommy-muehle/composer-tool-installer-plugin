<?php

namespace ToolInstaller\Tests\Composer;

use Composer\Plugin\Capability\CommandProvider;
use ToolInstaller\Composer\Plugin;

class PluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Plugin
     */
    private $plugin;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->plugin = new Plugin;
    }

    public function testCommandProviderIsRegistered()
    {
        $capabilities = $this->plugin->getCapabilities();

        $this->assertTrue(is_array($capabilities));
        $this->assertArrayHasKey(CommandProvider::class, $capabilities);
    }

    public function testCanGetCRegisteredCommands()
    {
        $commands = $this->plugin->getCommands();
        $this->assertCount(2, $commands);
    }

    public function testCanGetSubscribedEvents()
    {
        $events = Plugin::getSubscribedEvents();

        $this->assertTrue(is_array($events));
        $this->assertArrayHasKey('post-install-cmd', $events);
        $this->assertArrayHasKey('post-update-cmd', $events);
    }
}
