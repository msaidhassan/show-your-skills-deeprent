<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UnitSizeFilter extends Component
{
    public $selectedSize = ''; // Track the selected size
    public $sizeOptions = []; // Store the size options
    public $units = []; // Store the filtered units
    public $filteredUnits = []; // Store the filtered units

    public function mount()
    {

        // Get the JSON file path from configuration
        $jsonPath = config('filesystems.unit_data_json_path');

        // Check if the file exists
        if (!File::exists($jsonPath)) {
            Log::error("File not found: $jsonPath");
            abort(404, "File not found: $jsonPath");
        }

        // Read the JSON file
        $jsonContent = File::get($jsonPath);

        // Check if the JSON content is empty
        if (empty($jsonContent)) {
            Log::error("JSON file is empty: $jsonPath");
            abort(404, "JSON file is empty");
        }

        // Decode the JSON content
        $jsonData = json_decode($jsonContent, true);

        // Handle JSON decoding errors
        if ($jsonData === null) {
            Log::error("JSON Decoding Error: " . json_last_error_msg());
            abort(500, "JSON Decoding Error: " . json_last_error_msg());
        }

        // Extract size options from the JSON data
        $this->sizeOptions = $jsonData['sizeOptions'];

        // Extract all units for filtering
        $this->units = $jsonData['units'];
        $this->filteredUnits = $this->units; // Initialize filtered units with all units

    }

    public function updatedSelectedSize($size)
    {
        if (empty($size)) {
            $this->filteredUnits = $this->units; // Show all units if no size is selected
        } else {
            $this->filteredUnits = collect($this->units)->filter(function ($unit) use ($size) {
                return $unit['size'] === $size;
            })->values()->toArray();
        }


    }

    public function render()
    {
        return view('livewire.unit-size-filter', [
            'sizeOptions' => $this->sizeOptions,
            'filteredUnits' => $this->filteredUnits,
        ]);
    }
}
