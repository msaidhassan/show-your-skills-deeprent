<div class="max-w-4xl mx-auto p-5">
    <!-- Dropdown for Unit Sizes -->
    <div class="mb-5">
        <label for="size-select" class="mr-2 text-lg font-medium">Select Unit Size:</label>
        <select wire:model.live="selectedSize" id="size-select"
            class="p-2 border border-gray-300 rounded-md text-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
            <option value="">All Sizes</option>
            @foreach ($sizeOptions as $size)
                <option value="{{ $size }}">{{ $size }}</option>
            @endforeach
        </select>
    </div>

    <!-- Display Filtered Units -->
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-lg">
                    <th class="px-4 py-2 text-left">Unit Name</th>
                    <th class="px-4 py-2 text-left">Length</th>
                    <th class="px-4 py-2 text-left">Width</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Size</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($filteredUnits as $unit)
                    <tr class="border-b border-gray-300 hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $unit['name'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $unit['length'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $unit['width'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $unit['price'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $unit['status'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $unit['size'] ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No units found for the selected size.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
