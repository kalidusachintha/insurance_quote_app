<?php

use App\Models\Destination;
use App\Services\Pricing\Contracts\PricingStrategyInterface;
use App\Services\Pricing\PricingStrategyFactory;

describe('Price strategy test', function () {
    beforeEach(function () {});

    it('Can return correct price strategy', function () {
        $destination = Destination::factory()->create(
            ['id' => 1, 'name' => 'America', 'code' => 'AMER', 'base_price' => 30.00]
        );
        $pricingFactory = new PricingStrategyFactory;
        $result = $pricingFactory->initializePricing($destination);

        expect($result)->toBeInstanceOf(PricingStrategyInterface::class);

    });

    it('Can throw exceptions', function () {
        $destination = Destination::factory()->create(
            ['id' => 1, 'name' => 'AUS', 'code' => 'AUS', 'base_price' => 30.00]
        );
        $pricingFactory = new PricingStrategyFactory;

        expect(fn () => $pricingFactory->initializePricing($destination))
            ->toThrow(InvalidArgumentException::class, 'Unsupported destination: AUS');

    });
});
