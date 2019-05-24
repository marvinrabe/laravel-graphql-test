<?php

namespace MarvinRabe\LaravelGraphQLTest;

trait TestGraphQL
{

    /**
     * Returns a TestGraphQL client. If no arguments and selection is provided, it will query the server directly.
     * @param  string  $object  GraphQL query name
     * @param  array|null  $arguments  Specifies arguments send to the server. When selection is null it will be used as a selection set instead.
     * @param  array|null  $selection  Specifies Selection set send to the server.
     * @return GraphQLClient|\Illuminate\Foundation\Testing\TestResponse
     */
    protected function query(string $object, $arguments = null, $selection = null)
    {
        $client = GraphQLClient::query($object, function ($query) {
            return $this->postJson(
                $this->graphQLEndpoint ?? 'graphql',
                [
                    'query' => $query,
                ]
            );
        });

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

    /**
     * Returns a TestGraphQL client. If no arguments and selection is provided, it will query the server directly.
     * @param  string  $object  GraphQL query name
     * @param  array|null  $arguments  Specifies arguments send to the server.
     * @param  array|null  $selection  Specifies Selection set send to the server.
     * @return GraphQLClient|\Illuminate\Foundation\Testing\TestResponse
     */
    protected function mutation(string $object, $arguments = null, $selection = null)
    {
        $client = GraphQLClient::mutation($object, function ($query) {
            return $this->postJson(
                $this->graphQLEndpoint ?? 'graphql',
                [
                    'query' => $query,
                ]
            );
        });

        if ($arguments != null || $selection != null) {
            $client->setArguments($arguments);
            $client->setSelectionSet($selection);
            return $client->getData();
        }

        return $client;
    }
}
