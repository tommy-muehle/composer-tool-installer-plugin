<?php

namespace Tooly\Composer\Generator\Questions;

use Tooly\Composer\Generator\Autocomplete\SuggesterInterface;
use Symfony\Component\Console\Question\Question;

abstract class AbstractQuestion extends Question
{
    public function saveAutocompleterValues($value)
    {
        $suggester = $this->getSuggester();

        if (true === $suggester->has($value)) {
            return;
        }

        $suggester->add($value);
    }

    /**
     * @return SuggesterInterface
     */
    abstract protected function getSuggester();
}
