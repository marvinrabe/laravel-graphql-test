<?php

namespace MarvinRabe\LaravelGraphQLTest;

use MarvinRabe\LaravelGraphQLTest\Scalars\EnumType;

trait TestGraphQL
{

    abstract public function postJson($uri, array $data = [], array $headers = []);

    public function enum($value)
    {
        return new EnumType($value);
    }

    /**
     * Returns a TestGraphQL client. If no arguments and selection is provided, it will query the server directly.
     * @param  string  $object  GraphQL query name
     * @param  array|null  $arguments  Specifies arguments send to the server. When selection is null it will be used as a selection set instead.
     * @param  array|null  $selection  Specifies Selection set send to the server.
     * @return GraphQLClient|\Illuminate\Foundation\Testing\TestResponse
     */
    public function query(string $object, $arguments = null, $selection = null)
    {
        $client = GraphQLClient::query($object, function ($query) {
            return $this->postJson(
                $this->graphQLEndpoint ?? 'graphql',
                [
                    'query' => $query,
                ]
            );
        });

        return $this->prepareClient($client, $arguments, $selection);
    }

    /**
     * Returns a TestGraphQL client. If no arguments and selection is provided, it will query the server directly.
     * @param  string  $object  GraphQL query name
     * @param  array|null  $arguments  Specifies arguments send to the server. When selection is null it will be used as a selection set instead.
     * @param  array|null  $selection  Specifies Selection set send to the server.
     * @return GraphQLClient|\Illuminate\Foundation\Testing\TestResponse
     */
    public function mutation(string $object, $arguments = null, $selection = null)
    {
        $client = GraphQLClient::mutation($object, function ($query) {
            return $this->postJson(
                $this->graphQLEndpoint ?? 'graphql',
                [
                    'query' => $query,
                ]
            );
        });

        return $this->prepareClient($client, $arguments, $selection);
    }

    private function prepareClient(GraphQLClient $client, $arguments, $selection)
    {
        if ($arguments != null && $selection == null) {
            $client->setSelectionSet($arguments);
            return $client->getData();
        }

        if ($arguments != null && $selection != null) {
            $client->setArguments($arguments);
            $client->setSelectionSet($selection);
            return $client->getData();
        }

        return $client;
    }
}
