<?php

namespace Tooly\Composer\Generator\Autocomplete;

interface SuggesterInterface
{
    /**
     * @return array
     */
    public function all();

    /**
     * @param string $value
     *
     * @return bool
     */
    public function has($value);

    /**
     * @param string $value
     */
    public function add($value);
}
