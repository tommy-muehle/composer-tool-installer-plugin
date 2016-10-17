<?php

namespace ToolInstaller\Composer\Command\Autocomplete;

abstract class AbstractSuggester implements SuggesterInterface
{
    /**
     * @var string
     */
    private $file;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->getValues();
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function has($value)
    {
        $values = $this->getValues();

        return in_array($value, $values);
    }

    /**
     * @param string $value
     */
    public function add($value)
    {
        $values = $this->getValues();
        $values[] = $value;

        $this->saveValues($values);
    }

    /**
     * @return array
     */
    private function getValues()
    {
        if (false === file_exists($this->file)) {
            return [];
        }

        return unserialize(file_get_contents($this->file));
    }

    /**
     * @param array $values
     */
    private function saveValues(array $values)
    {
        file_put_contents($this->file, serialize($values));
    }
}
