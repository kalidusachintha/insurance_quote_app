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
            'EUR' => new EuropePricingStrategy($destination->base_price),
            'ASIA' => new AsiaPricingStrategy($destination->base_price),
            'AMER' => new AmericaPricingStrategy($destination->base_price),
            default => throw new InvalidArgumentException("Unsupported destination: {$destination->name}"),
        };
    }
}
