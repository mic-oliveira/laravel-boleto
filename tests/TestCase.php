<?php

namespace Boleto\Tests;

use Boleto\Providers\ServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate', [
            '--database' => 'sqlite',
            '--realpath' => realpath(__DIR__.'/../src/migrations'),
        ]);
        /*$this->loadMigrationsFrom(realpath(__DIR__.'/../src/migrations'));
        $this->withFactories(realpath(__DIR__.'/../src/factories'));*/
    }

    protected function defineDatabaseMigrations()
    {
        $this->artisan('migrate', ['--database' => 'sqlite']);
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('database.default', 'sqlite');
    }
}
