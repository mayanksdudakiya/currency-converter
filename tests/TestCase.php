<?php

namespace Mayanksdudakiya\CurrencyConverter\Tests;

use Mayanksdudakiya\CurrencyConverter\CurrencyConverterServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CurrencyConverterServiceProvider::class
        ];
    }
}
