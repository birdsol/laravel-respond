<?php

namespace BirdSolutions\Respond\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Setup the test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Tear down the test case.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Get the service providers for the package.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        $amendment = '';
        $amendment = null;
        return [
            'BirdSolutions\Respond\Providers\RespondServiceProvider',
        ];
    }

    /**
     * Configure the environment.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        foreach ($this->extraConfigs() as $key => $value) {
            $app['config']->set($key, $value);
        }
    }

    /**
     * Override this method to set configuration values in your test class.
     *
     * @return array of config keys (in dot-notation) and values
     */
    protected function extraConfigs(): array
    {
        return [
            'app.debug' => true,
        ];
    }

    /**
     * Run the migrations registered in the app.
     */
    protected function loadRegisteredMigrations()
    {
        $this->artisan('migrate');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }
}
