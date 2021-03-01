<?php

namespace MySource\Lumberjack\Tests;

use Orchestra\Testbench\TestCase;
use MySource\Lumberjack\LumberjackServiceProvider;

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
