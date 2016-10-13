<?php

namespace Tooly\Composer\Installer;

use Composer\Composer;
use Tooly\Composer\Model\Tool;

class Configuration
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $binDirectory;

    /**
     * @var string
     */
    private $composerBinDirectory;

    /**
     * @param Composer $composer
     * @param Mode     $mode
     */
    public function __construct(Composer $composer, Mode $mode)
    {
        $extras = $composer->getPackage()->getExtra();

        if (true === array_key_exists('tools', $extras)) {
            $this->data = array_merge([], $extras['tools']);
        }

        $this->mode = $mode;
        $this->binDirectory = realpath(__DIR__ . '/../../bin');
        $this->composerBinDirectory = $composer->getConfig()->get('bin-dir');
    }

    /**
     * @return bool
     */
    public function isDevMode()
    {
        return $this->mode->isDev();
    }

    /**
     * @return bool
     */
    public function isInteractiveMode()
    {
        return $this->mode->isInteractive();
    }

    /**
     * @return string
     */
    public function getBinDirectory()
    {
        return $this->binDirectory;
    }

    /**
     * @return string
     */
    public function getComposerBinDirectory()
    {
        return $this->composerBinDirectory;
    }

    /**
     * @return array
     */
    public function getTools()
    {
        $tools = [];

        foreach ($this->data as $name => $parameters) {
            $tools[] = $this->createTool($name, $this->binDirectory, $parameters);
        }

        return $tools;
    }

    /**
     * @param string $name
     * @param string $directory
     * @param array  $parameters
     *
     * @return Tool
     */
    private function createTool($name, $directory, array $parameters)
    {
        $defaults = [
            'url' => null,
            'sign-url' => null,
            'only-dev' => true,
            'force-replace' => false,
        ];

        $parameters = array_merge($defaults, $parameters);

        $tool = new Tool(
            $name,
            $this->getFilename($name, $directory),
            $parameters['url'],
            $parameters['sign-url']
        );

        if (true === $parameters['force-replace']) {
            $tool->activateForceReplace();
        }

        if (false === $parameters['only-dev']) {
            $tool->disableOnlyDev();
        }

        return $tool;
    }

    /**
     * @param string $name
     * @param string $directory
     *
     * @return string
     */
    private function getFilename($name, $directory)
    {
        $filename = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $filename .= str_replace('.phar', '', $name) . '.phar';

        return $filename;
    }
}
