<?php

namespace App\Services\Pricing\Contracts;

use App\DTO\QuoteDTO;
use Illuminate\Database\Eloquent\Collection;

interface PricingStrategyInterface
{
    public function calculate(QuoteDTO $quoteDTO, Collection $coverageOptions): float;
}
