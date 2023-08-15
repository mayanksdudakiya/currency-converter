<?php

namespace Mayanksdudakiya\CurrencyConverter;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;
use Throwable;

class CurrencyConverter
{
    /**
     * @return array<string|string>
     */
    public function getCurrencyData(): array
    {
        try {
            $response = Http::retry(3, 100)->get(config('currency-converter.exchange_url'));
            $xmlString = $response->body();

            return $this->prepareCurrencyLookupArray($xmlString);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * @param string $xmlString
     * @return array<string|string>
     */
    private function prepareCurrencyLookupArray(string $xmlString): array
    {
        $xml = new SimpleXMLElement($xmlString);

        $currencies = [];
        foreach ($xml->Cube->Cube->Cube as $cube) {
            $attributes = $cube->attributes();
            $currency = (string) $attributes['currency'];
            $currencies[$currency] = (string) $attributes['rate'];
        }

        return $currencies;
    }

    /**
     * @param string $currency
     * @param int|float $amount
     * @return null|float
     */
    public function execute(string $currency, int|float $amount): ?float
    {
        $this->storeCurrencyInCache();
        $currencies = Cache::get('currencies');

        if (empty($currencies[$currency])) {
            return null;
        }

        return round($amount * $currencies[$currency], 2);
    }

    public function storeCurrencyInCache(): void
    {
        $cachedCurrencies = Cache::get('currencies');
        if (empty($cachedCurrencies)) {
            $currencies = $this->getCurrencyData();
            Cache::put('currencies', $currencies, now()->addHours(24));
        }
    }
}
