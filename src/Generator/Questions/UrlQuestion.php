<?php

namespace Tooly\Composer\Generator\Questions;

use Tooly\Composer\Generator\Autocomplete\UrlSuggester;

class UrlQuestion extends AbstractQuestion
{
    private $suggester;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->suggester = new UrlSuggester;

        parent::__construct('Url:');
    }

    /**
     * @return array
     */
    public function getAutocompleterValues()
    {
        return $this->suggester->all();
    }

    /**
     * @return UrlSuggester
     */
    protected function getSuggester()
    {
        return $this->suggester;
    }
}
