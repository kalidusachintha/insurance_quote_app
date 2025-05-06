<?php

namespace App\Repositories;

use App\DTO\QuoteDTO;
use App\Models\Quote;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use Illuminate\Support\Facades\DB;

class QuoteRepository implements QuoteRepositoryInterface
{
    /**
     * @param Quote $quote
     */
    public function __construct(
        public Quote $quote
    ) {
    }

    /**
     * Create quote
     *
     * @param QuoteDTO $quoteDTO
     * @return Quote
     */
    public function create(QuoteDTO $quoteDTO): Quote
    {
        return DB::transaction(function () use ($quoteDTO) {
            $quote = $this->quote->create([
                'destination_id' => $quoteDTO->destinationId,
                'start_date' => $quoteDTO->startDate,
                'end_date' => $quoteDTO->endDate,
                'number_of_travelers' => $quoteDTO->numberOfTravelers,
                'total_price' => $quoteDTO->totalPrice,
            ]);

            if (!empty($quoteDTO->coverageOptionIds)) {
                $quote->coverageOptions()->attach($quoteDTO->coverageOptionIds);
            }

            return $quote;
        });
    }
}
