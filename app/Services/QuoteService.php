<?php

namespace App\Services;

use App\DTO\QuoteDTO;
use App\Models\Quote;
use App\Repositories\Contracts\CoverageOptionsRepositoryInterface;
use App\Repositories\Contracts\DestinationRepositoryInterface;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use App\Services\Pricing\Contracts\StandardQuoteInterface;
use App\Services\Pricing\PricingStrategyFactory;

class QuoteService implements StandardQuoteInterface
{
    /**
     * @param DestinationRepositoryInterface $destinationRepository
     * @param CoverageOptionsRepositoryInterface $coverageOptionRepository
     * @param QuoteRepositoryInterface $quoteRepository
     * @param PricingStrategyFactory $pricingStrategyFactory
     */
    public function __construct(
        private DestinationRepositoryInterface $destinationRepository,
        private CoverageOptionsRepositoryInterface $coverageOptionRepository,
        private QuoteRepositoryInterface $quoteRepository,
        private PricingStrategyFactory $pricingStrategyFactory,
    ) {}

    /**
     * Calculate the Quote
     *
     * @param QuoteDTO $quoteDTO
     * @return float
     */
    public function calculateQuote(QuoteDTO $quoteDTO): float
    {
        $destination = $this->destinationRepository->findDestinationById($quoteDTO->destinationId);
        $coverageOptions = $this->coverageOptionRepository->findCoverageOptionsById($quoteDTO->coverageOptionIds);
        $pricingStrategy = $this->pricingStrategyFactory->initializePricing($destination);

        return $pricingStrategy->calculate($quoteDTO, $coverageOptions);
    }

    /**
     * Save the calculated Quote
     *
     * @param QuoteDTO $quoteDTO
     * @return Quote
     */
    public function createQuote(QuoteDTO $quoteDTO): Quote
    {
        if ($quoteDTO->totalPrice === null) {
            $totalPrice = $this->calculateQuote($quoteDTO);
            $quoteDTO = new QuoteDTO(
                destinationId: $quoteDTO->destinationId,
                startDate: $quoteDTO->startDate,
                endDate: $quoteDTO->endDate,
                numberOfTravelers: $quoteDTO->numberOfTravelers,
                coverageOptionIds: $quoteDTO->coverageOptionIds,
                totalPrice: $totalPrice
            );
        }

        return $this->quoteRepository->create($quoteDTO);
    }
}
