<?php

namespace Tests\Unit\Services;

use App\DTO\QuoteDTO;
use App\Models\CoverageOption;
use App\Models\Destination;
use App\Models\Quote;
use App\Repositories\Contracts\CoverageOptionsRepositoryInterface;
use App\Repositories\Contracts\DestinationRepositoryInterface;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use App\Services\Pricing\Contracts\PricingStrategyInterface;
use App\Services\Pricing\PricingStrategyFactory;
use App\Services\QuoteService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

describe('Testing quote services', function () {
    beforeEach(function () {
        $this->destinationRepository = Mockery::mock(DestinationRepositoryInterface::class);
        $this->coverageOptionRepository = Mockery::mock(CoverageOptionsRepositoryInterface::class);
        $this->quoteRepository = Mockery::mock(QuoteRepositoryInterface::class);
        $this->pricingStrategyFactory = Mockery::mock(PricingStrategyFactory::class);
        $this->pricingStrategy = Mockery::mock(PricingStrategyInterface::class);

        $this->quoteService = new QuoteService(
            $this->destinationRepository,
            $this->coverageOptionRepository,
            $this->quoteRepository,
            $this->pricingStrategyFactory
        );

    });

    afterEach(function () {
        Mockery::close();
    });

    it('Calculate quote correctly', function () {

        $quoteDTO = new QuoteDTO(
            destinationId: 1,
            startDate: new \DateTime(now()->format('Y-m-d')),
            endDate: new \DateTime(now()->addDays(7)->format('Y-m-d')),
            numberOfTravelers: 2,
            coverageOptionIds: [1, 2],
            totalPrice: null
        );

        $destination = Destination::factory()->create(['id' => 1, 'name' => 'America', 'code' => 'AMER', 'base_price' => 30.00]);
        $coverageOptions = new Collection([
            CoverageOption::factory()->make([
                'id' => 1,
                'name' => 'Medical',
                'base_price' => 50,
            ]),
            CoverageOption::factory()->make([
                'id' => 2,
                'name' => 'Cancellation',
                'base_price' => 30,
            ]),
        ]);

        $this->destinationRepository->shouldReceive('findDestinationById')
            ->once()
            ->with(1)
            ->andReturn($destination);

        $this->coverageOptionRepository->shouldReceive('findCoverageOptionsById')
            ->once()
            ->with([1, 2])
            ->andReturn($coverageOptions);

        $this->pricingStrategyFactory->shouldReceive('initializePricing')
            ->once()
            ->with($destination)
            ->andReturn($this->pricingStrategy);

        $this->pricingStrategy->shouldReceive('calculate')
            ->once()
            ->with($quoteDTO, $coverageOptions)
            ->andReturn(160.00);

        $result = $this->quoteService->calculateQuote($quoteDTO);

        expect($result)->toBe(160.00);
    });

    it('Creates quote correctly', function () {

        $quoteDTO = new QuoteDTO(
            destinationId: 1,
            startDate: new \DateTime(now()->format('Y-m-d')),
            endDate: new \DateTime(now()->addDays(7)->format('Y-m-d')),
            numberOfTravelers: 2,
            coverageOptionIds: [1, 2],
            totalPrice: 160.00
        );

        $quote = new Quote;
        $quote->id = 1;
        $quote->total_price = 160.00;

        $this->quoteRepository->shouldReceive('create')
            ->once()
            ->with($quoteDTO)
            ->andReturn($quote);

        $result = $this->quoteService->createQuote($quoteDTO);

        expect($result)
            ->toBeInstanceOf(Quote::class)
            ->and((float) $result->total_price)->toBe(160.00);
    });

});
