<?php

namespace MarvinRabe\LaravelGraphQLTest\Scalars;

use MarvinRabe\LaravelGraphQLTest\Scalar;

class BooleanType implements Scalar
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value ? 'true' : 'false';
    }

    public static function match($value): bool
    {
        return is_bool($value);
    }
}
