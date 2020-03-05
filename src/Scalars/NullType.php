<?php

namespace MarvinRabe\LaravelGraphQLTest\Scalars;

use MarvinRabe\LaravelGraphQLTest\Scalar;

class NullType implements Scalar
{
    public function __toString()
    {
        return 'null';
    }

    public static function match($value): bool
    {
        return $value === null;
    }
}
