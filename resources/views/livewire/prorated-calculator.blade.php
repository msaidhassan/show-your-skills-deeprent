<div class="min-h-screen flex flex-col items-center justify-start bg-gray-100 p-6">
    <!-- Title at the top -->
    <h1 class="text-3xl font-bold mb-4 text-center">Prorated Rent Calculator</h1>

    <!-- Form section (hidden in PDF) -->
    @if(!$isPdf)
        <div class="w-full max-w-md bg-white p-6 shadow-lg rounded-lg">
            <form wire:submit.prevent="calculate" class="space-y-4">
                <div>
                    <label for="moveInDate" class="block text-sm font-medium text-gray-700">Move-In Date</label>
                    <input type="date" id="moveInDate" wire:model="moveInDate" required
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="monthlyRent" class="block text-sm font-medium text-gray-700">Monthly Rent</label>
                    <input type="number" step="0.01" id="monthlyRent" wire:model="monthlyRent" required
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Calculate
                </button>
            </form>
        </div>
    @endif

    <!-- Results section -->
    @if (!empty($proratedData))
        <div class="w-full max-w-md mt-4 p-4 bg-gray-50 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-center">Prorated Rent Details</h2>
            <div class="space-y-2">
                <p><strong>Start Date:</strong> {{ $proratedData['start_date'] }}</p>
                <p><strong>End Date:</strong> {{ $proratedData['end_date'] }}</p>
                <p><strong>Price Per Day:</strong> ${{ number_format($proratedData['price_per_day'], 2) }}</p>
                <p><strong>Number of Days:</strong> {{ $proratedData['days'] }}</p>
                <p><strong>Prorated Rent:</strong> ${{ number_format($proratedData['prorated_rent'], 2) }}</p>
            </div>
        </div>

        <!-- Export as PDF button (hidden in PDF) -->
        @if(!$isPdf)
            <div class="mt-4 text-center">
                <button wire:click="export"
                    class="w-full py-2 px-4 text-white bg-green-600 hover:bg-green-700 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Export as PDF
                </button>
            </div>
        @endif
    @endif
</div>
