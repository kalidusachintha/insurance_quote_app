<div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-10 text-center">Get Your Quote</h2>
    <form wire:submit="calculateQuote" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
            <!-- Destination -->
            <div>
                <label for="destinationId" class="block text-sm font-bold text-gray-700">Destination</label>
                <select
                    wire:model="destinationId"
                    id="destinationId"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                >
                    <option value="">Select a destination</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}" wire:key="{{ $destination->id }}">{{ $destination->name }} (+${{ number_format($destination->base_price, 2) }})</option>
                    @endforeach
                </select>
                @error('destinationId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Number of Travelers -->
            <div>
                <label for="numberOfTravelers" class="block text-sm font-bold text-gray-700">Number of Travelers</label>
                <input
                    type="number"
                    wire:model="numberOfTravelers"
                    id="numberOfTravelers"
                    min="1"
                    max="10"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                >
                @error('numberOfTravelers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>


        <!-- Travel Dates -->
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
            <div>
                <label for="startDate" class="block text-sm font-bold text-gray-700">Start Date</label>
                <input
                    type="date"
                    wire:model="startDate"
                    id="startDate"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    min="{{ now()->format('Y-m-d') }}"
                >
                @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="endDate" class="block text-sm font-bold text-gray-700">End Date</label>
                <input
                    type="date"
                    wire:model="endDate"
                    id="endDate"
                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                    min="{{ now()->format('Y-m-d') }}"
                >
                @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>



        <!-- Coverage Options -->
        <div>
            <label class="block text-sm font-bold text-gray-700">Coverage Options</label>
            <div class="mt-4 space-y-4">
                @foreach($coverageOptions as $option)
                    <div class="flex items-start" wire:key="{{ $option->id }}">
                        <div class="flex items-center h-5">
                            <input
                                type="checkbox"
                                wire:model="selectedCoverageOptions"
                                id="coverage_{{ $option->id }}"
                                value="{{ $option->id }}"
                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="coverage_{{ $option->id }}" class="font-medium text-gray-700">{{ $option->name }} (+${{ number_format($option->price, 2) }})</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <button
                type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                wire:loading.attr="disabled"
            >
                <span>Calculate Quote</span>
            </button>

            @if($quote)
                <button
                    type="button"
                    wire:click="resetForm"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Start New Quote
                </button>
            @endif
        </div>
    </form>

    <!-- Errors -->
    @error('form')
    <div class="mt-6 bg-red-50 border-l-4 border-red-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">{{ $message }}</p>
            </div>
        </div>
    </div>
    @enderror

    <span wire:loading>
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Calculating...
    </span>
    @if($quote)
        @include('livewire.quote-result')
    @endif
</div>

    <!-- Quote Results -->


