<?php

namespace Mayanksdudakiya\CurrencyConverter;

/**
 * @OA\Tag(
 *     name="Currency",
 *     description=" European Central Bank daily exchange currency API"
 * )
 */
class CurrencyConverterController
{
    /**
     * @OA\Get(
     *     path="/api/v1/convert-currency",
     *     summary="Eurpoean currency exchange",
     *     tags={"Currency"},
     *     security={{}},
     *     @OA\Parameter(
     *      name="amount",
     *      parameter="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(type="number"),
     *     ),
     *     @OA\Parameter(
     *      name="currency",
     *      parameter="currency",
     *      in="query",
     *      required=false,
     *      @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="NotFound"),
     *     @OA\Response(response=422, description="Unprocessable"),
     *     @OA\Response(response=500, description="ServerError")
     * )
     */
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
