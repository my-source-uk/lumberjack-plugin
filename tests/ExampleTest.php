<?php

namespace MySource\Lumberjack\Tests;

use MySource\Lumberjack\LumberjackServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LumberjackServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
