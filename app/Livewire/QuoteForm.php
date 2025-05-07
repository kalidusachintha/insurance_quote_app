<?php

namespace App\Livewire;

use App\DTO\QuoteDTO;
use App\Models\Quote;
use App\Repositories\Contracts\CoverageOptionsRepositoryInterface;
use App\Repositories\Contracts\DestinationRepositoryInterface;
use App\Services\Pricing\Contracts\StandardQuoteInterface;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class QuoteForm extends Component
{
    public Collection $destinations;

    public Collection $coverageOptions;

    public int $destinationId;

    public string $startDate;

    public string $endDate;

    public int $numberOfTravelers = 1;

    public array $selectedCoverageOptions = [];

    public array $quote = [];

    public bool $isLoading = false;

    protected function rules()
    {
        return [
            'destinationId' => 'required|exists:destinations,id',
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate',
            'numberOfTravelers' => 'required|integer|min:1|max:10',
        ];
    }

    protected function messages()
    {
        return [
            'destinationId.required' => 'Please select a destination.',
            'destinationId.exists' => 'The selected destination is invalid.',
            'startDate.required' => 'Please enter a start date for your trip.',
            'startDate.after_or_equal' => 'The start date must be today or later.',
            'endDate.required' => 'Please enter an end date for your trip.',
            'endDate.after_or_equal' => 'The end date must be after or equal to the start date.',
            'numberOfTravelers.required' => 'Please enter the number of travelers.',
            'numberOfTravelers.min' => 'The minimum number of travelers is 1.',
            'numberOfTravelers.max' => 'The maximum number of travelers is 10.',
        ];
    }

    public function mount(
        DestinationRepositoryInterface $destinationRepository,
        CoverageOptionsRepositoryInterface $coverageOptionRepository
    ) {
        $this->destinations = $destinationRepository->getAllDestinations();
        $this->coverageOptions = $coverageOptionRepository->getAllCoverageOptions();
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->addDays(7)->format('Y-m-d');
    }

    public function calculateQuote(StandardQuoteInterface $quoteService)
    {
        $this->validate();
        $this->isLoading = true;
        $this->quote = [];

        try {
            $quoteDTO = new QuoteDTO(
                destinationId: $this->destinationId,
                startDate: new DateTime($this->startDate),
                endDate: new DateTime($this->endDate),
                numberOfTravelers: $this->numberOfTravelers,
                coverageOptionIds: $this->selectedCoverageOptions
            );
            $totalPrice = $quoteService->calculateQuote($quoteDTO);
            $quoteDTO->totalPrice = $totalPrice;
            $quote = $quoteService->createQuote($quoteDTO);
            $this->setQuote($quote);

        } catch (\Exception $e) {
            $this->addError('form', 'An error occurred while calculating your quote: '.$e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'destinationId',
            'startDate',
            'endDate',
            'numberOfTravelers',
            'selectedCoverageOptions',
            'quote',
        ]);

        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->addDays(7)->format('Y-m-d');
    }

    private function setQuote(Quote $quote): void
    {
        $this->quote = [
            'id' => $quote->id,
            'destination' => $quote->destination->name,
            'start_date' => $quote->start_date->format('Y-m-d'),
            'end_date' => $quote->end_date->format('Y-m-d'),
            'number_of_travelers' => $quote->number_of_travelers,
            'coverage_options' => $quote->coverageOptions->pluck('name')->toArray(),
            'total_price' => number_format($quote->total_price, 2),
            'trip_duration' => $quote->start_date->diffInDays($quote->end_date) + 1,
        ];
    }

    public function render()
    {
        return view('livewire.quote-form');
    }
}
