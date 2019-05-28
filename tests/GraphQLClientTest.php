<?php

use MarvinRabe\LaravelGraphQLTest\GraphQLClient;
use PHPUnit\Framework\TestCase;

class GraphQLClientTest extends TestCase
{

    /** @test */
    public function it_converts_null_to_array()
    {
        $client = GraphQLClient::query('foo', function () {
        });
        $client->setArguments(null);
        $client->setSelectionSet(null);

        $this->assertEquals('query { foo }', $client->getGql());
    }

    /** @test */
    public function it_returns_a_query()
    {
        $client = GraphQLClient::query('foo', function () {
        });
        $client->setArguments(['id' => 123]);
        $client->setSelectionSet(['bar']);

        $this->assertEquals("query { foo(id: 123){\nbar\n} }", $client->getGql());
    }

}
