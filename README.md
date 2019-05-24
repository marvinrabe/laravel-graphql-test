# laravel-graphql-test
Provides you a simple GraphQL testing trait.
## Installation

Install this library with composer

    composer require marvinrabe/laravel-graphql-test

Add the trait to your `TestCase` class:

```php
<?php

namespace Tests;

abstract class TestCase extends BaseTestCase
{
    use MarvinRabe\LaravelGraphQLTest\TestGraphQL;

    // ...
}
```

## Usage

### Queries

Full query:

```php
$this->query('account', ['id' => 123], ['id']);
```

With nested resources:

```php
$this->query('account', ['id' => 123], ['transactions' => ['id']]);
```

Without a third argument it will be assumed that the second one is the selection set:

```php
$this->query('accounts', ['id']);
```

When you pass the object name only you get the `GraphQLClient`:

```php
$this->query('accounts')->getGql();
```

### Mutations

Same as queries. But without the third argument the second one still has to be a GraphQL argument array: 

```php
$this->mutation('accounts', ['id' => 123]); 
```

## Limitations

The `QueryBuilder` provided by this library is not safe for use in production code. It is designed for tests only and does not comply to the GraphQL specifications fully. Use it only for testing purposes! You have been warned.
