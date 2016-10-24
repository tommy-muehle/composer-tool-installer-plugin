<?php

namespace ToolInstaller\Composer\Model;

class Tool
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $signUrl;

    /**
     * @var string
     */
    private $keyUrl;

    /**
     * @var bool
     */
    private $forceReplace = false;

    /**
     * @var bool
     */
    private $onlyDev = true;

    /**
     * @param string $name
     * @param string $url
     * @param string $signUrl
     * @param string $keyUrl
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct($name, $url, $signUrl = null, $keyUrl = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->signUrl = $signUrl;
        $this->keyUrl = $keyUrl;
    }

    /**
     * @return void
     */
    public function activateForceReplace()
    {
        $this->forceReplace = true;
    }

    /**
     * @return void
     */
    public function disableOnlyDev()
    {
        $this->onlyDev = false;
    }

    /**
     * @return bool
     */
    public function hasKeyFile()
    {
        return isset($this->keyUrl);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return basename($this->url);
    }

    /**
     * @return null|string
     */
    public function getKeyFilename()
    {
        if (true === $this->hasKeyFile()) {
            return basename($this->keyUrl);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getSignUrl()
    {
        return $this->signUrl;
    }

    /**
     * @return string
     */
    public function getKeyUrl()
    {
        return $this->keyUrl;
    }

    /**
     * @return boolean
     */
    public function isOnlyDev()
    {
        return $this->onlyDev;
    }

    /**
     * @return bool
     */
    public function forceReplace()
    {
        return $this->forceReplace;
    }
}
