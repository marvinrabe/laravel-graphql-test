<?php

namespace MarvinRabe\LaravelGraphQLTest;

interface Scalar
{
    public static function match($value): bool;

    public function __toString();
}
