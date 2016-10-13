<?php

namespace Tooly\Composer\Generator\Autocomplete;

use Composer\Factory;

class UrlSuggester extends AbstractSuggester
{
    public function __construct()
    {
        $configuration = Factory::createConfig();
        $file = $configuration->get('cache-dir') . DIRECTORY_SEPARATOR . 'tooly_urls';

        parent::__construct($file);
    }
}
