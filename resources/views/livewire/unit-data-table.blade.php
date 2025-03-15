<div class="w-4/5 mx-auto">
    <!-- Search Input -->
    <div class="mb-4 flex items-center space-x-2">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Search Units..."
            class="w-1/3 p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300"
            id="search-input"
            list="unit-names"
            x-on:input="$wire.selectedUnitUpdated($event.target.value)"
            x-on:clear-search.window="$el.value = ''"
        >
        <datalist id="unit-names" class="absolute bg-white border border-gray-300 rounded-md w-full max-h-40 overflow-y-auto">
            @foreach ($unitNames as $name)
                <option value="{{ $name }}"></option>
            @endforeach
        </datalist>
        <button wire:click="clearSelection" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            Clear
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border-b">Unit Name</th>
                    <th class="px-4 py-2 border-b">Length</th>
                    <th class="px-4 py-2 border-b">Width</th>
                    <th class="px-4 py-2 border-b">Price</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Size</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($units as $unit)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border-b">{{ $unit['name'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b">{{ $unit['length'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b">{{ $unit['width'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b">{{ $unit['price'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b">{{ $unit['status'] ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b">{{ $unit['size'] ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No units found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-between items-center">
        <div class="text-gray-500 text-sm">
            Showing {{ $units->firstItem() }} to {{ $units->lastItem() }} of {{ $units->total() }} results
        </div>
        <div class="mt-4 flex justify-end items-center">
            {{ $units->links('livewire::tailwind') }}

        </div>
    </div>
</div>
