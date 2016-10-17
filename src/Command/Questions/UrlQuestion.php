<?php

namespace ToolInstaller\Composer\Command\Questions;

use ToolInstaller\Composer\Command\Autocomplete\UrlSuggester;

class UrlQuestion extends AbstractQuestion
{
    private $suggester;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->suggester = new UrlSuggester;

        parent::__construct('Url: ');
    }

    /**
     * @return array
     */
    public function getAutocompleterValues()
    {
        return $this->getSuggester()->all();
    }

    /**
     * @return UrlSuggester
     */
    protected function getSuggester()
    {
        return $this->suggester;
    }
}
