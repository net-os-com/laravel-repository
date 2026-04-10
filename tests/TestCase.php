<?php

namespace Programic\Repository\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Programic\Repository\RepositoryServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            RepositoryServiceProvider::class,
        ];
    }
}
