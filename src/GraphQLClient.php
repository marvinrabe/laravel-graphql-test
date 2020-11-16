<?php

namespace MarvinRabe\LaravelGraphQLTest;

class GraphQLClient
{
    /**
     * @var QueryBuilder
     */
    protected $builder;

    /**
     * @var callable
     */
    protected $endpoint;

    protected function __construct(QueryBuilder $builder, callable $fun)
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
     * @psalm-suppress UndefinedDocblockClass
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function getData()
    {
        return ($this->endpoint)($this->getGql());
    }

    public function getGql(): string
    {
        return $this->builder->getGql();
    }
}
