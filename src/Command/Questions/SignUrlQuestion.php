<?php

namespace ToolInstaller\Composer\Command\Questions;

use ToolInstaller\Composer\Command\Autocomplete\SignUrlSuggester;
use ToolInstaller\Composer\Command\Autocomplete\UrlSuggester;

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

        parent::__construct('Sign url (default: none): ', '');
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
