<?php

namespace MarvinRabe\LaravelGraphQLTest;

class GraphQLClient
{

    protected $endpoint;

    /**
     * GraphQLClient constructor.
     * @param  QueryBuilder  $builder
     * @param $fun
     */
    protected function __construct($builder, $fun)
    {
        $this->builder = $builder;
        $this->endpoint = $fun;
    }

    public static function query($object, $fun)
    {
        return new self(new QueryBuilder("query", $object), $fun);
    }

    public static function mutation($object, $fun)
    {
        return new self(new QueryBuilder("mutation", $object), $fun);
    }

    public function setArguments(array $arguments = null)
    {
        $this->builder->setArguments($arguments ?? []);
        return $this;
    }

    public function setSelectionSet(array $selectionSet = null)
    {
        $this->builder->setSelectionSet($selectionSet ?? []);
        return $this;
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function getData()
    {
        return ($this->endpoint)($this->getGql());
    }

    /**
     * Returns GQL string.
     * @return string
     */
    public function getGql()
    {
        return $this->builder->getGql();
    }

}
