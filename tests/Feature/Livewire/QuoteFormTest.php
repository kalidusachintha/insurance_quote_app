<?php

use App\Livewire\QuoteForm;
use App\Models\CoverageOption;
use App\Models\Destination;
use App\Repositories\Contracts\CoverageOptionsRepositoryInterface;
use App\Repositories\Contracts\DestinationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Livewire;

describe('QuoteForm test', function () {

    it('renders successfully', function () {
        Livewire::test(QuoteForm::class)
            ->assertStatus(200);
    });

    it('QuoteForm can be instantiated', function () {
        $component = new QuoteForm;
        expect($component)->toBeInstanceOf(QuoteForm::class);
    });

    it('mount method sets initial properties', function () {

        $destinations = new Collection([
            Destination::factory()->create([
                'id' => 1,
                'name' => 'America',
                'code' => 'AMER',
                'base_price' => 30.00,
            ]),
            Destination::factory()->create([
                'id' => 2,
                'name' => 'Asia',
                'code' => 'ASIA',
                'base_price' => 20.00,
            ]),
            Destination::factory()->create([
                'id' => 3,
                'name' => 'Europe',
                'code' => 'EUR',
                'base_price' => 10.00,
            ]),

        ]);
        $coverageOptions = new Collection([
            CoverageOption::factory()->create([
                'id' => 1,
                'name' => 'Medical Expenses',
                'code' => 'MEDICAL',
                'price' => 20.00,
            ]),
            CoverageOption::factory()->create([
                'id' => 2,
                'name' => 'Trip Cancellation',
                'code' => 'CANCEL',
                'price' => 30.00,
            ]),
        ]);

        $destinationRepo = Mockery::mock(DestinationRepositoryInterface::class);
        $destinationRepo->shouldReceive('getAllDestinations')->once()->andReturn($destinations);

        $coverageRepo = Mockery::mock(CoverageOptionsRepositoryInterface::class);
        $coverageRepo->shouldReceive('getAllCoverageOptions')->once()->andReturn($coverageOptions);

        $component = new QuoteForm;
        $component->mount($destinationRepo, $coverageRepo);

        expect($component->destinations)->toBe($destinations)
            ->and($component->coverageOptions)->toBe($coverageOptions)
            ->and($component->startDate)->toBe(now()->format('Y-m-d'))
            ->and($component->endDate)->toBe(now()->addDays(7)->format('Y-m-d'))
            ->and($component->numberOfTravelers)->toBe(1);
    });
});
