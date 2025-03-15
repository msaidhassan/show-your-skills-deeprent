<div wire:init class="flex justify-center items-center h-screen relative">
    <!-- Overlay (Shows during loading or success) -->
    <div wire:loading wire:target="showSuccess" class="fixed inset-0 bg-black bg-opacity-50 z-50"></div>
    @if ($success)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50"></div>
    @endif

    <!-- Centered Button (Hidden when loading starts) -->
    <button wire:click="showSuccess" wire:loading.remove class="px-6 py-3 text-lg bg-blue-500 text-white rounded-md transition duration-300 hover:bg-blue-700">
        Click Me
    </button>

    <!-- Loading Spinner (Centered) -->
    <div wire:loading wire:target="showSuccess" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
        <div class="w-12 h-12 border-4 border-gray-300 border-t-blue-500 rounded-full animate-spin"></div>
    </div>

    <!-- Success Popup -->
    @if ($success)
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-5 rounded-lg shadow-lg text-center z-50">
            <span wire:click="$set('success', false)" class="absolute top-2 right-2 text-red-500 text-lg cursor-pointer hover:text-red-700">✖</span>
            <div class="text-4xl text-green-500 mb-2">✔</div>
            <div class="text-lg font-bold text-gray-800">Success!</div>
        </div>
    @endif
</div>
