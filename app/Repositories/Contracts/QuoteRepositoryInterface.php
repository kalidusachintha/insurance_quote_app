<?php

namespace App\Repositories\Contracts;

use App\DTO\QuoteDTO;
use App\Models\Quote;

interface QuoteRepositoryInterface
{
    public function create(QuoteDTO $quoteDTO): Quote;
}
