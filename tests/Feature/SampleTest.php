<?php

namespace Mayanksdudakiya\CurrencyConverter\Tests\Feature;

use Mayanksdudakiya\CurrencyConverter\Tests\TestCase;

class SampleTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function currency_conversion()
    {
        $this->get(route('convert.currency'))->assertOk();
    }

}
