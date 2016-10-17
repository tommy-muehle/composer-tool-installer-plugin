<?php

namespace ToolInstaller\Composer\Installer\Decision;

use ToolInstaller\Composer\Installer\Configuration;
use ToolInstaller\Composer\Installer\Decision\DecisionInterface;
use ToolInstaller\Composer\Installer\Helper;

/**
 * @package ToolInstaller\Script\Decision
 */
abstract class AbstractDecision implements DecisionInterface
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @param Configuration $configuration
     * @param Helper        $helper
     */
    public function __construct(Configuration $configuration, Helper $helper)
    {
        $this->configuration = $configuration;
        $this->helper = $helper;
    }
}
