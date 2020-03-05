<?php

namespace MarvinRabe\LaravelGraphQLTest\Scalars;

use MarvinRabe\LaravelGraphQLTest\Scalar;

class EnumType implements Scalar
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public static function match($value): bool
    {
        return false;
    }
}
