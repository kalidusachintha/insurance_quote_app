<?php

namespace App\DTO;

use DateTime;

readonly class QuoteDTO
{
    public function __construct(
        public int      $destinationId,
        public DateTime $startDate,
        public DateTime $endDate,
        public int      $numberOfTravelers,
        public array    $coverageOptionIds = [],
        public ?float   $totalPrice = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            destinationId: $data['destination_id'],
            startDate: new DateTime($data['start_date']),
            endDate: new DateTime($data['end_date']),
            numberOfTravelers: $data['number_of_travelers'],
            coverageOptionIds: $data['coverage_options'] ?? [],
            totalPrice: $data['total_price'] ?? null
        );
    }
}
