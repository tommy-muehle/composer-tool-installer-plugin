<?php

namespace Tooly\Composer\Generator\Autocomplete;

use Composer\Factory;

class NameSuggester extends AbstractSuggester
{
    public function __construct()
    {
        $configuration = Factory::createConfig();
        $file = $configuration->get('cache-dir') . DIRECTORY_SEPARATOR . 'tooly_names';

        parent::__construct($file);
    }
}
