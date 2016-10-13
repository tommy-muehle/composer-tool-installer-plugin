<?php

namespace Tooly\Composer\Installer\Decision;

use Tooly\Composer\Installer\Configuration;
use Tooly\Composer\Installer\Decision\DecisionInterface;
use Tooly\Composer\Installer\Helper;

/**
 * @package Tooly\Script\Decision
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
