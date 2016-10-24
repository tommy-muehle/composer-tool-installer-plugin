<?php

namespace ToolInstaller\Composer\Command\Questions;

use ToolInstaller\Composer\Command\Autocomplete\KeyUrlSuggester;

class KeyUrlQuestion extends AbstractQuestion
{
    /**
     * @var KeyUrlSuggester
     */
    private $suggester;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->suggester = new KeyUrlSuggester;

        parent::__construct('Key url (default: none, example: https://tool.phar.pubkey): ', '');
    }

    /**
     * @return array
     */
    public function getAutocompleterValues()
    {
        return $this->getSuggester()->all();
    }

    /**
     * @return KeyUrlSuggester
     */
    protected function getSuggester()
    {
        return $this->suggester;
    }
}
