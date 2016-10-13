<?php

namespace Tooly\Composer\Generator\Questions;

use Tooly\Composer\Generator\Autocomplete\NameSuggester;

class NameQuestion extends AbstractQuestion
{
    private $suggester;

    public function __construct()
    {
        $this->suggester = new NameSuggester;

        parent::__construct('Name:');
    }

    public function getAutocompleterValues()
    {
        $defaults = [
            'phpunit', 'phpcs', 'phpcpd', 'pdepend', 'codeception', 'behat',
            'security-checker'
        ];

        return array_merge($defaults, $this->suggester->all());
    }

    protected function getSuggester()
    {
        return $this->suggester;
    }
}
