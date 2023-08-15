<?php

namespace Mayanksdudakiya\CurrencyConverter;

class CurrencyConverterController
{
    public function __invoke(CurrencyRequest $request)
    {
        dd($request->all());
    }
}
