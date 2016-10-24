<?php

namespace ToolInstaller\Composer\Command\Questions;

use ToolInstaller\Composer\Command\Autocomplete\SignUrlSuggester;

class SignUrlQuestion extends AbstractQuestion
{
    /**
     * @var SignUrlSuggester
     */
    private $suggester;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->suggester = new SignUrlSuggester;

        parent::__construct('Sign url (default: none, example: https://tool.phar.asc): ', '');
    }

    /**
     * @return array
     */
    public function getAutocompleterValues()
    {
        return $this->getSuggester()->all();
    }

    /**
     * @return SignUrlSuggester
     */
    protected function getSuggester()
    {
        return $this->suggester;
    }
}
