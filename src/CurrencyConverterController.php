<?php

namespace Mayanksdudakiya\CurrencyConverter;

class CurrencyConverterController
{
    public function __invoke(CurrencyRequest $request, CurrencyConverter $currencyConverter)
    {
        $convertedAmount = $currencyConverter->execute($request->input('currency', 'USD'), $request->amount);

        return response()->json([
            'success' => $convertedAmount ? 1 : 0,
            'data' => $convertedAmount,
            'error' => $convertedAmount === null ? 'No currency found' : ''
        ]);
    }
}
