<div class="max-w-md mx-auto p-6 border border-gray-300 rounded-lg bg-gray-100 shadow-md">
    <h2 class="text-center text-xl font-bold mb-5">Metric Converter</h2>

    <!-- Feet Input -->
    <div class="mb-4">
        <label for="feet" class="block mb-1 font-medium">Feet:</label>
        <input
            type="text"
            wire:model.live="feet"
            id="feet"
            placeholder="Enter feet"
            class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
            x-on:input="$wire.findMeters($event.target.value)"
            x-on:feet-convert.window="$el.value = $event.detail.feet"
        >
    </div>

    <!-- Meters Input -->
    <div>
        <label for="meters" class="block mb-1 font-medium">Meters:</label>
        <input
            type="text"
            wire:model.live="meters"
            id="meters"
            placeholder="Enter meters"
            class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
            x-on:input="$wire.findFeet($event.target.value)"
            x-on:meter-convert.window="$el.value = $event.detail.meters"
        >
    </div>
</div>
