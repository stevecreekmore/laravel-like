<?php

namespace stevecreekmore\LaravelLike\Tests;

use stevecreekmore\LaravelLike\LaravelLikeServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelLikeServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/migrations/create_users_table.php';

        (new \CreateUsersTable)->up();
    }
}
