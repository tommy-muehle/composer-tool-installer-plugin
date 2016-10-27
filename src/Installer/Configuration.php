<?php

namespace ToolInstaller\Composer\Installer;

use Composer\Composer;
use ToolInstaller\Composer\Defaults;
use ToolInstaller\Composer\Model\Tool;

class Configuration
{
    /**
     * @var array
     */
    private $configuration = [
        'bin-directory' => __DIR__ . '/../../bin',
        'interactive-mode' => Defaults::INTERACTIVE_MODE,
        'dev-mode' => Defaults::DEV_MODE,
        'composer-bin-directory' => null,
        'tools' => [],
    ];

    /**
     * @param Composer $composer
     */
    public function __construct(Composer $composer)
    {
        $extras = $composer->getPackage()->getExtra();

        if (true === array_key_exists('tools', $extras)) {
            $this->configuration['tools'] = array_merge($this->configuration['tools'], $extras['tools']);
        }

        $this->configuration['composer-bin-directory'] = $composer->getConfig()->get('bin-dir');
    }

    /**
     * @return bool
     */
    public function isDevMode()
    {
        return $this->configuration['dev-mode'];
    }

    /**
     * Set flag for composer dev-mode to false.
     */
    public function setNoDev()
    {
        $this->configuration['dev-mode'] = false;
    }

    /**
     * Set flag for CLI interaction to false.
     */
    public function setNonInteractive()
    {
        $this->configuration['interactive-mode'] = false;
    }

    /**
     * @return bool
     */
    public function isInteractiveMode()
    {
        return $this->configuration['interactive-mode'];
    }

    /**
     * @return string
     */
    public function getBinDirectory()
    {
        return realpath($this->configuration['bin-directory']);
    }

    /**
     * @return string
     */
    public function getComposerBinDirectory()
    {
        return $this->configuration['composer-bin-directory'];
    }

    /**
     * @return array
     */
    public function getTools()
    {
        $tools = [];

        foreach ($this->configuration['tools'] as $name => $parameters) {
            $tools[] = $this->createTool($name, $parameters);
        }

        return $tools;
    }

    /**
     * @param string $name
     * @param array  $parameters
     *
     * @return Tool
     */
    private function createTool($name, array $parameters)
    {
        $defaults = [
            'url' => null,
            'sign-url' => null,
            'key-url' => null,
            'only-dev' => true,
            'force-replace' => false,
        ];

        $parameters = array_merge($defaults, $parameters);

        $tool = new Tool(
            $name,
            $parameters['url'],
            $parameters['sign-url'],
            $parameters['key-url']
        );

        if (true === $parameters['force-replace']) {
            $tool->activateForceReplace();
        }

        if (false === $parameters['only-dev']) {
            $tool->disableOnlyDev();
        }

        return $tool;
    }
}
