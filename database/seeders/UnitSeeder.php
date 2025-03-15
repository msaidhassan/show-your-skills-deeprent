<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

use Illuminate\Support\Facades\File;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = config('filesystems.unit_data_json_path');

        if (!File::exists($jsonPath)) {
            Log::error("File not found: $jsonPath");
           // return view('livewire.unit-data-table', ['units' => collect([])]);
        }

        $jsonContent = File::get($jsonPath);
        if (empty($jsonContent)) {
            Log::error("JSON file is empty: $jsonPath");
            //return view('livewire.unit-data-table', ['units' => collect([])]);
        }

        $jsonData = json_decode($jsonContent, true);
        if ($jsonData === null) {
            Log::error("JSON Decoding Error: " . json_last_error_msg());
         //   return view('livewire.unit-data-table', ['units' => collect([])]);
        }

        $units = collect($jsonData['units']);

        // Insert data into the units table
        foreach ($units as $unit) {
            Unit::create([
                'name' => $unit['name'],
                'length' => $unit['length'],
                'width' => $unit['width'],
                'price' => $unit['price'],
                'status' => $unit['status'],
            ]);
        }
    }
}
