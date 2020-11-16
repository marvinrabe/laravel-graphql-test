<?php

namespace MarvinRabe\LaravelGraphQLTest\Tests;

use MarvinRabe\LaravelGraphQLTest\QueryBuilder;

class QueryBuilderTest extends TestCase
{
    public function testFormatEmptyQuery()
    {
        $qb = new QueryBuilder('query', 'foo');
        $qb->setArguments([]);
        $qb->setSelectionSet([]);

        $this->assertEquals("query { foo }", $qb->getGql());
    }

    public function testFormatSelectionSet()
    {
        $qb = new QueryBuilder('query', 'acme');
        $qb->setSelectionSet([
            'foo',
            'bar',
        ]);

        $this->assertEquals("query { acme{\nfoo\nbar\n} }", $qb->getGql());
    }

    public function testFormatNestedQueries()
    {
        $qb = new QueryBuilder('query', 'acme');
        $qb->setSelectionSet([
            'foo' => ['bar'],
        ]);

        $this->assertEquals("query { acme{\nfoo {\nbar\n}\n} }", $qb->getGql());
    }

    public function testFormatStringAttributes()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => 'Jonathan "Johnny" Johnson',
        ]);

        $this->assertEquals('mutation { foo(bar: "Jonathan \"Johnny\" Johnson") }', $qb->getGql());
    }

    public function testFormatsBoolean()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => true,
        ]);

        $this->assertEquals('mutation { foo(bar: true) }', $qb->getGql());
    }

    public function testFormatsInputArguments()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => ['a' => 1, 'b' => 2, 'c' => 3],
        ]);

        $this->assertEquals('mutation { foo(bar: {a: 1, b: 2, c: 3}) }', $qb->getGql());
    }

    public function testFormatsArrayArguments()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => [1, 2, 3],
        ]);

        $this->assertEquals('mutation { foo(bar: [1, 2, 3]) }', $qb->getGql());
    }

    public function testFormatInputsInArrayArgument()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => [['a' => 1], ['a' => 2], ['a' => 3]],
        ]);

        $this->assertEquals('mutation { foo(bar: [{a: 1}, {a: 2}, {a: 3}]) }', $qb->getGql());
    }
}
