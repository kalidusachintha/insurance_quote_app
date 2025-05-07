<?php

namespace App\DTO;

use DateTime;

class QuoteDTO
{
    public function __construct(
        public readonly int $destinationId,
        public readonly DateTime $startDate,
        public readonly DateTime $endDate,
        public readonly int $numberOfTravelers,
        public readonly array $coverageOptionIds = [],
        public ?float $totalPrice = null
    ) {}

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
