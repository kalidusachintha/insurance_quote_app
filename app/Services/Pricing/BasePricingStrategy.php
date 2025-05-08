<?php

namespace App\Services\Pricing;

use App\DTO\QuoteDTO;
use App\Services\Pricing\Contracts\PricingStrategyInterface;
use Illuminate\Support\Facades\Cache;

abstract class BasePricingStrategy implements PricingStrategyInterface
{
    public function __construct(protected float $basePrice) {}

    /**
     * Calculate price with options
     *
     * @param QuoteDTO $quoteDTO
     * @param $coverageOptions
     * @return float
     */
    public function calculate(QuoteDTO $quoteDTO, $coverageOptions): float
    {
        $cacheKey = $this->generateCacheKey($quoteDTO, $coverageOptions);

        return Cache::remember($cacheKey, now()->addHours(1), function () use ($quoteDTO, $coverageOptions) {
            $coveragePrice = $coverageOptions->sum('price');

            return $quoteDTO->numberOfTravelers * ($this->basePrice + $coveragePrice);
        });
    }

    /**
     * Generate cache key for repeated request
     *
     * @param QuoteDTO $quoteDTO
     * @param $coverageOptions
     * @return string
     */
    protected function generateCacheKey(QuoteDTO $quoteDTO, $coverageOptions): string
    {
        $coverageIds = $coverageOptions->pluck('id')->sort()->implode('-');

        return sprintf(
            'price_calculation_%s_%s_%s_%d_%s',
            static::class,
            $quoteDTO->startDate->format('Y-m-d'),
            $quoteDTO->endDate->format('Y-m-d'),
            $quoteDTO->numberOfTravelers,
            $coverageIds
        );
    }
}
