<?php

use MarvinRabe\LaravelGraphQLTest\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{

    /** @test */
    public function it_formats_string_arguments()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => 'Jonathan "Johnny" Johnson'
        ]);

        $this->assertEquals('mutation { foo(bar: "Jonathan \"Johnny\" Johnson") }', $qb->getGql());
    }

    /** @test */
    public function it_formats_boolean_arguments()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => true
        ]);

        $this->assertEquals('mutation { foo(bar: true) }', $qb->getGql());
    }

    /** @test */
    public function it_formats_input_arguments()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => ['a' => 1, 'b' => 2, 'c' => 3]
        ]);

        $this->assertEquals('mutation { foo(bar: {a: 1, b: 2, c: 3}) }', $qb->getGql());
    }

    /** @test */
    public function it_formats_array_arguments()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => [1, 2, 3]
        ]);

        $this->assertEquals('mutation { foo(bar: [1, 2, 3]) }', $qb->getGql());
    }

    /** @test */
    public function it_formats_inputs_in_array_arguments()
    {
        $qb = new QueryBuilder('mutation', 'foo');
        $qb->setArguments([
            'bar' => [['a' => 1], ['a' => 2], ['a' => 3]]
        ]);

        $this->assertEquals('mutation { foo(bar: [{a: 1}, {a: 2}, {a: 3}]) }', $qb->getGql());
    }

}
