<div>
    <h1 class="text-xl font-bold mb-4">Unit Management</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-2 mb-4">{{ session('message') }}</div>
    @endif

    <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 mb-4">Add New Unit</button>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Name</th>
                <th class="border p-2">Size</th>
                <th class="border p-2">Price</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($units as $unit)
                <tr class="border" wire:key="unit-{{ $unit->id }}">
                    <td class="p-2">{{ $unit->name }}</td>
                    <td class="p-2">{{ $unit->length }} x {{ $unit->width }}</td>
                    <td class="p-2">${{ number_format($unit->price, 2) }}</td>
                    <td class="p-2">{{ ucfirst($unit->status) }}</td>
                    <td class="p-2">
                        <button wire:click="edit({{ $unit->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $unit->id }})" class="bg-red-500 text-white px-3 py-1 rounded">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Livewire pagination links -->
    <div class="mt-4 flex justify-between items-center">
        <div class="text-gray-500 text-sm">
            Showing {{ $units->firstItem() }} to {{ $units->lastItem() }} of {{ $units->total() }} results
        </div>
        <div class="mt-4 flex justify-end items-center">
            {{ $units->links('livewire::tailwind') }}

        </div>
    </div>

    <!-- Popup Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h2 class="text-lg font-bold mb-4">{{ $isEditMode ? 'Edit Unit' : 'Create Unit' }}</h2>

                <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'create' }}">
                    <div class="mb-2">
                        <label class="block text-sm">Unit Name:</label>
                        <input type="text" wire:model="name" class="w-full p-2 border rounded">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm">Length:</label>
                        <input type="number" step="0.01" wire:model="length" class="w-full p-2 border rounded">
                        @error('length') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm">Width:</label>
                        <input type="number" step="0.01" wire:model="width" class="w-full p-2 border rounded">
                        @error('width') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm">Price:</label>
                        <input type="number" step="0.01" wire:model="price" class="w-full p-2 border rounded">
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm">Status:</label>
                        <select wire:model="status" class="w-full p-2 border rounded">
                            <option value="">Select Status</option>
                            <option value="available">Available</option>
                            <option value="rented">Rented</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                        {{ $isEditMode ? 'Update' : 'Create' }} Unit
                    </button>
                    <button type="button" wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancel</button>
                </form>
            </div>
        </div>
    @endif

    {{-- @props(['id' => null, 'maxWidth' => '2xl']) --}}
    <div wire:ignore>
        <div x-data="{ show: false }"
             x-on:show-delete-modal.window="show = true"
             x-show="show"
             class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900">Confirm Delete</h2>
                <div class="mt-4 text-gray-700">
                    <p>Are you sure you want to delete this unit?</p>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button @click="show = false" class="bg-gray-500 text-white px-3 py-1 rounded">Cancel</button>
                    <button @click="show = false; $dispatch('delete-method')" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                </div>
            </div>
        </div>
    </div>


</div>
