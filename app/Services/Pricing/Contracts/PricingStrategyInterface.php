<?php

namespace App\Services\Pricing\Contracts;

use App\DTO\QuoteDTO;

interface PricingStrategyInterface
{
    public function calculate(QuoteDTO $quoteDTO, array $coverageOptions): float;
}
