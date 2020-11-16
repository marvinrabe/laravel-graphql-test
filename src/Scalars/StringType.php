<?php

namespace MarvinRabe\LaravelGraphQLTest\Scalars;

use MarvinRabe\LaravelGraphQLTest\Scalar;

class StringType implements Scalar
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        $escaped = str_replace('\\', '\\\\', $this->value);
        $escaped = str_replace('"', '\"', $escaped);

        return sprintf('"%s"', $escaped);
    }

    public static function match($value): bool
    {
        return is_string($value);
    }
}
