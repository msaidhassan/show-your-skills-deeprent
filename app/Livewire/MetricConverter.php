<?php

namespace App\Livewire;

use Livewire\Component;

class MetricConverter extends Component
{
    public $feet = ''; // Input for feet
    public $meters = ''; // Input for meters

    // Conversion constants
    const FEET_TO_METERS = 0.3048;
    const METERS_TO_FEET = 3.28084;

    // Real-time conversion for feet input
    public function findMeters($value)
    {
        // Validate input
        if (!is_numeric($value)) {
            $this->feet = ''; // Clear invalid input
            $this->meters = ''; // Clear meters as well
            return;
        }

        // Convert feet to meters
        $this->meters = number_format((float)$value * self::FEET_TO_METERS, 2);

        // Dispatch event to update the meters input field
        $this->dispatch('meter-convert', meters: $this->meters);

    }

    // Real-time conversion for meters input
    public function findFeet($value)
    {

        // Validate input
        if (!is_numeric($value)) {
            $this->meters = ''; // Clear invalid input
            $this->feet = ''; // Clear feet as well
            return;
        }

        // Convert meters to feet
        $this->feet = number_format((float)$value * self::METERS_TO_FEET, 2);
        // Dispatch event to update the feet input field
        $this->dispatch('feet-convert', feet: $this->feet);
    }

    public function render()
    {
        return view('livewire.metric-converter');
    }
}
