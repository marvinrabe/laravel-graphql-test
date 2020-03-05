<?php

namespace Test;

use MarvinRabe\LaravelGraphQLTest\GraphQLClient;
use MarvinRabe\LaravelGraphQLTest\Scalars\EnumType;
use PHPUnit\Framework\TestCase;

class TestGraphQLTest extends TestCase
{

    public function testEnum()
    {
        $testCase = new FakeTestCase();

        $result = $testCase->enum('payed');

        $this->assertInstanceOf(EnumType::class, $result);
        $this->assertEquals('payed', (string) $result);
    }

    public function testQueryOneArgument()
    {
        $testCase = new FakeTestCase();

        $result = $testCase->query('accounts');

        $this->assertInstanceOf(GraphQLClient::class, $result);
    }

    public function testQueryTwoArguments()
    {
        $testCase = new FakeTestCase();

        $testCase->query('accounts', ['id']);

        $this->assertEquals('graphql', $testCase->uri);
        $this->assertEquals(['query' => "query { accounts{\nid\n} }"], $testCase->data);
    }

    public function testQueryThreeArguments()
    {
        $testCase = new FakeTestCase();

        $testCase->query('accounts', ['id' => 123], ['id']);

        $this->assertEquals('graphql', $testCase->uri);
        $this->assertEquals(['query' => "query { accounts(id: 123){\nid\n} }"], $testCase->data);
    }

    public function testMutationOneArgument()
    {
        $testCase = new FakeTestCase();

        $result = $testCase->mutation('createAccount');

        $this->assertInstanceOf(GraphQLClient::class, $result);
    }

    public function testMutationTwoArguments()
    {
        $testCase = new FakeTestCase();

        $testCase->mutation('createAccount', ['id']);

        $this->assertEquals('graphql', $testCase->uri);
        $this->assertEquals(['query' => "mutation { createAccount{\nid\n} }"], $testCase->data);
    }

    public function testMutationThreeArguments()
    {
        $testCase = new FakeTestCase();

        $testCase->mutation('createAccount', ['id' => 123], ['id']);

        $this->assertEquals('graphql', $testCase->uri);
        $this->assertEquals(['query' => "mutation { createAccount(id: 123){\nid\n} }"], $testCase->data);
    }

}
