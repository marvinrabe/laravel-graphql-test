<?php

namespace MarvinRabe\LaravelGraphQLTest;

class QueryBuilder
{

    protected $operation;

    protected $object;

    protected $arguments;

    protected $selectionSet;

    /**
     * TestGraphQLBuilder constructor.
     * @param  string  $operation  Choose "query" or "mutation"
     * @param  string  $object
     */
    public function __construct($operation, $object)
    {
        $this->operation = $operation;
        $this->object = $object;
    }

    public function setSelectionSet($selectionSet)
    {
        $this->selectionSet = $selectionSet;
        return $this;
    }

    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    public function getGql(): string
    {
        return sprintf('%s { %s }', $this->operation, implode("", [
            $this->object,
            $this->arguments(),
            $this->selectionSet()
        ]));
    }

    protected function arguments()
    {
        if ($this->arguments === null) {
            return '';
        }
        $qgl = $this->formatArgument($this->arguments);
        return "($qgl)";
    }

    protected function formatArgument($arguments)
    {
        array_walk($arguments, function (&$value, $key) {
            $value = sprintf('%s: %s', $key, $this->formatValue($value));
        });

        return implode(', ', $arguments);
    }

    protected function is_assoc(array $array)
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

    protected function selectionSet()
    {
        if ($this->selectionSet === null || count($this->selectionSet) === 0) {
            return '';
        }
        return "{\n".$this->formatSelectionSet($this->selectionSet)."\n}";
    }

    protected function formatSelectionSet($selectionSet)
    {
        array_walk($selectionSet, function (&$value, $key) {
            if (is_array($value)) {
                $value = "$key {\n".$this->formatSelectionSet($value)."\n}";
            }
        });

        return implode("\n", $selectionSet);
    }

    protected function formatValue($value)
    {
        if (is_array($value) && $this->is_assoc($value)) {
            return "{".$this->formatArgument($value)."}";
        } elseif (is_array($value)) {
            return $this->formatArray($value);
        }
        return $this->formatScalar($value);
    }

    protected function formatArray(array $value)
    {
        return sprintf('[%s]', implode(', ', array_map(function ($value) {
            return $this->formatValue($value);
        }, $value)));
    }

    protected function formatScalar($scalar)
    {
        if ($scalar === null) {
            return 'null';
        } elseif (is_string($scalar)) {
            $escaped = str_replace('\\', '\\\\', $scalar);
            $escaped = str_replace('"', '\"', $escaped);
            return "\"$escaped\"";
        } elseif (is_bool($scalar)) {
            return $scalar ? 'true' : 'false';
        }
        return (string) $scalar;
    }

    public function __toString()
    {
        return $this->getGql();
    }

}
