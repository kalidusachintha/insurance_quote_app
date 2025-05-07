<?php

namespace App\Services\Pricing;

use App\Models\Destination;
use App\Services\Pricing\Contracts\PricingStrategyInterface;
use InvalidArgumentException;

class PricingStrategyFactory
{
    /**
     * Initiate pricing
     *
     * @param Destination $destination
     * @return PricingStrategyInterface
     */
    public function initializePricing(Destination $destination): PricingStrategyInterface
    {
        return match ($destination->code) {
            'EUR' => new EuropePricingStrategy((float)$destination->base_price),
            'ASIA' => new AsiaPricingStrategy((float)$destination->base_price),
            'AMER' => new AmericaPricingStrategy((float)$destination->base_price),
            default => throw new InvalidArgumentException("Unsupported destination: {$destination->name}"),
        };
    }
}
