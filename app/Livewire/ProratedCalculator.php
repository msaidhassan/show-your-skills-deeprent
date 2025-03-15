<?php
namespace App\Livewire;

use Livewire\Component;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;

class ProratedCalculator extends Component
{
    public $moveInDate;
    public $monthlyRent;
    public $proratedData = [];
    public $isPdf = false;  // Flag to determine if rendering for PDF

    public function calculate()
    {
        $this->validate([
            'moveInDate' => 'required|date',
            'monthlyRent' => 'required|numeric|min:0',
        ]);

        $moveInDate = new DateTime($this->moveInDate);
        $monthlyRent = (float) filter_var($this->monthlyRent, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Calculate end of the month
        $endOfMonth = (new DateTime($moveInDate->format('Y-m-t')))->modify('+1 day');
        $days = $moveInDate->diff($endOfMonth)->days;
        $daysInMonth = (int) $moveInDate->format('t');
        $pricePerDay = $monthlyRent / $daysInMonth;
        $proratedRent = $pricePerDay * $days;

        // Store calculated data
        $this->proratedData = [
            'start_date' => $moveInDate->format('Y-m-d'),
            'end_date' => $endOfMonth->format('Y-m-d'),
            'price_per_day' => $pricePerDay,
            'days' => $days,
            'prorated_rent' => $proratedRent,
        ];
    }

    public function export()
    {
        $sanitizedData = array_map(function ($value) {
            return is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'UTF-8') : $value;
        }, $this->proratedData);

        // Pass the flag to the view
        $pdf = Pdf::loadView('livewire.prorated-calculator', [
            'proratedData' => $sanitizedData,
            'isPdf' => true,  // Indicate that this is a PDF export
        ])
        ->setPaper('a4')
        ->setOption('defaultFont', 'sans-serif');

        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'prorated-rent-calculator.pdf'
        );
    }
}
