<?php

namespace NetOS\Repository\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use NetOS\Repository\RepositoryServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            RepositoryServiceProvider::class,
        ];
    }
}
