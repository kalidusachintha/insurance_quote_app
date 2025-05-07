<?php

namespace App\Services\Pricing\Contracts;

use App\DTO\QuoteDTO;
use App\Models\Quote;

interface BaseQuoteServiceInterface
{
    public function calculateQuote(QuoteDTO $quoteDTO): float;

    public function createQuote(QuoteDTO $quoteDTO): Quote;
}
