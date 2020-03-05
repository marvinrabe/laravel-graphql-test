<?php

namespace Test;

use MarvinRabe\LaravelGraphQLTest\GraphQLClient;
use PHPUnit\Framework\TestCase;

class GraphQLClientTest extends TestCase
{

    public function testConvertsNullToArray()
    {
        $client = GraphQLClient::query('foo', function () {});
        $client->setArguments(null);
        $client->setSelectionSet(null);

        $this->assertEquals('query { foo }', $client->getGql());
    }

    public function testReturnsQuery()
    {
        $client = GraphQLClient::query('foo', function () {});
        $client->setArguments(['id' => 123]);
        $client->setSelectionSet(['bar']);

        $this->assertEquals("query { foo(id: 123){\nbar\n} }", $client->getGql());
    }
}
