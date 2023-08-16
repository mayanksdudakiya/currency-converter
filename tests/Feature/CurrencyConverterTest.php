<?php

namespace Mayanksdudakiya\CurrencyConverter\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Mayanksdudakiya\CurrencyConverter\CurrencyConverter;
use Mayanksdudakiya\CurrencyConverter\Tests\TestCase;

class CurrencyConverterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_amount_required_validation(): void
    {
        $this->getJson(route('convert.currency').'?amount=')
            ->assertUnprocessable();
    }

    public function test_amount_numeric_validation(): void
    {
        $this->getJson(route('convert.currency')."?amount=abc'")
        ->assertUnprocessable();
    }

    public function test_currency_format(): void
    {
        $this->getJson(route('convert.currency').'?amount=10&currency=usd')
            ->assertUnprocessable();

        $this->getJson(route('convert.currency').'?amount=10&currency=USDABCXYZ')
            ->assertUnprocessable();
    }

    public function test_unavailable_currency(): void
    {
        $this->getJson(route('convert.currency').'?amount=10&currency=EUR')
            ->assertUnprocessable();
    }

    public function test_currency_lookup_array(): void
    {
        $currencyXmlData = file_get_contents(__DIR__ . '/../Fixtures/CurrencyData.xml');

        $currencyLookup = app(CurrencyConverter::class)->prepareCurrencyLookupArray($currencyXmlData);

        $this->assertEquals($currencyLookup['USD'], '1.0926');
        $this->assertEquals($currencyLookup['JPY'], '159.04');
    }

    public function test_currency_conversion(): void
    {
        $currencyXmlData = file_get_contents(__DIR__ . '/../Fixtures/CurrencyData.xml');

        Http::fake([
            '*' => Http::response($currencyXmlData, 200),
        ]);

        $convertedCurrencyAmount = app(CurrencyConverter::class)->execute('USD', 10);

        $this->assertSame(round(1.0926 * 10, 2), $convertedCurrencyAmount);
    }
}
