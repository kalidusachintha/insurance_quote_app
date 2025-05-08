<div class="mt-8 bg-blue-50 rounded-lg p-6 shadow-sm border border-blue-100">
    <h3 class="text-lg font-semibold text-blue-900 mb-4">Your Travel Insurance Quote</h3>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <p class="text-sm font-medium text-gray-500">Destination</p>
            <p class="mt-1 text-lg font-medium text-gray-900">{{ $quote['destination'] }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-500">Trip Duration</p>
            <p class="mt-1 text-lg font-medium text-gray-900">{{ $quote['trip_duration'] }} days</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-500">Travel Dates</p>
            <p class="mt-1 text-lg font-medium text-gray-900">{{ $quote['start_date'] }} to {{ $quote['end_date'] }}</p>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-500">Number of Travelers</p>
            <p class="mt-1 text-lg font-medium text-gray-900">{{ $quote['number_of_travelers'] }}</p>
        </div>

        <div class="sm:col-span-2">
            <p class="text-sm font-medium text-gray-500">Selected Coverage</p>
            <div class="mt-1 text-lg font-medium text-gray-900">
                @if(count($quote['coverage_options']) > 0)
                    <ul class="list-disc list-inside">
                        @foreach($quote['coverage_options'] as $coverage)
                            <li>{{ $coverage }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No additional coverage selected</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6 border-t border-blue-200 pt-4">
        <div class="flex justify-between items-center">
            <p class="text-lg font-semibold text-gray-900">Total Price:</p>
            <p class="text-2xl font-bold text-blue-700">${{ $quote['total_price'] }}</p>
        </div>
        <p class="mt-2 text-sm text-gray-500">This quote is valid for 24 hours</p>
    </div>
</div>
