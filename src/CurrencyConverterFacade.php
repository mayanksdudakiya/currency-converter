<?php

namespace Mayanksdudakiya\CurrencyConverter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mayanksdudakiya\CurrencyConverter\Skeleton\SkeletonClass
 */
class CurrencyConverterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'currency-converter';
    }
}
