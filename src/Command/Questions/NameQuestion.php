<?php

namespace ToolInstaller\Composer\Command\Questions;

use ToolInstaller\Composer\Command\Autocomplete\NameSuggester;

class NameQuestion extends AbstractQuestion
{
    /**
     * @var NameSuggester
     */
    private $suggester;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->suggester = new NameSuggester;

        parent::__construct('Name of tool (such as phpunit or behat) to install: ');
    }

    /**
     * @return array
     */
    public function getAutocompleterValues()
    {
        $defaults = [
            'phpunit', 'phpcs', 'phpcpd', 'pdepend', 'codeception', 'behat',
            'security-checker'
        ];

        return array_merge($defaults, $this->getSuggester()->all());
    }

    /**
     * @return NameSuggester
     */
    protected function getSuggester()
    {
        return $this->suggester;
    }
}
