<?php

namespace Tooly\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;
use Tooly\Composer\Generator\Command\RequireCommand;

class Plugin implements PluginInterface, Capable, EventSubscriberInterface, CommandProviderCapability
{
    /**
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
    }

    /**
     * @return array
     */
    public function getCapabilities()
    {
        return [
            'Composer\Plugin\Capability\CommandProvider' => get_class($this)
        ];
    }

    /**
     * @return array
     */
    public function getCommands()
    {
        return [
            new RequireCommand,
        ];
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'install',
            ScriptEvents::POST_UPDATE_CMD  => 'install',
        ];
    }

    /**
     * @param Event $event
     */
    public function install(Event $event)
    {
        $installer = new Installer($event);

        $installer->cleanUp();
        $installer->process();
        $installer->symlink();
    }
}
