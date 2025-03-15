<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class RentPlanning extends Component
{
    public $desiredRent;
    public $monthlyProjections = [];
    public $chartData = [];

    private $initialMonthlyRent = 3000; // Starting rent per month
    public function __construct()
    {
        //parent::__construct();

        // Define rules dynamically
        $this->rules = [
            'desiredRent' => 'required|numeric|min:' . (12 * $this->initialMonthlyRent),
        ];
    }


    public function calculateRentPlan()
    {
        $this->validate();


        $currentMonth = Carbon::now()->month;
       // $currentMonth = 11;
        $remainingMonths = 12 - $currentMonth + 1;


        $interval_of_increase = intval($remainingMonths / 3);

        $num_of_months_frist_interval = $currentMonth + $interval_of_increase - 1;
        $total_rent_first_interval = $num_of_months_frist_interval * $this->initialMonthlyRent;
        if ($interval_of_increase == 0) {
            $interval_of_increase = 1;
        }
        $num_of_months_second_interval = $interval_of_increase;
        $total_rent_second_interval = $num_of_months_second_interval * $this->initialMonthlyRent;

        $num_of_months_third_interval = 12 - ($num_of_months_frist_interval + $num_of_months_second_interval);
        $total_rent_third_interval = $num_of_months_third_interval * $this->initialMonthlyRent;


        $remain_rent_of_all_interval = $this->desiredRent - $total_rent_first_interval - $total_rent_second_interval - $total_rent_third_interval;
        //dd($remain_rent_of_all_interval);

        $denominator = ($num_of_months_second_interval + $num_of_months_third_interval * 2);
        $increasePerMonth = ($denominator > 0) ? $remain_rent_of_all_interval / $denominator : 0;
        //dd($increasePerMonth);

        $this->chartData = [];
        $months = [];
        $increasePoints = [];
        $cumulativeRent = 0;

        foreach (range(1, $num_of_months_frist_interval) as $month) {
            $monthName = Carbon::create()->month($month)->format('F');
            $months[] = $monthName;
            $this->monthlyProjections[$monthName] = $this->initialMonthlyRent;
            $cumulativeRent += $this->initialMonthlyRent;
            $this->chartData['data'][] = $cumulativeRent;
        }
        // dd($num_of_months_frist_interval + 1+$num_of_months_second_interval -1);
        foreach (range($num_of_months_frist_interval + 1, $num_of_months_frist_interval + 1 + $num_of_months_second_interval - 1) as $index => $month) {
            $monthName = Carbon::create()->month($month)->format('F');
            $months[] = $monthName;
            // Calculate increasePoints only for the first month
            if ($index === 0) {
                $increasePoints[] = [
                    'month' => $monthName,
                    'percentage' => round(($increasePerMonth) / $this->initialMonthlyRent * 100, 2)
                ];
            }

            $this->monthlyProjections[$monthName] = $this->initialMonthlyRent + $increasePerMonth;
            $cumulativeRent += $this->initialMonthlyRent + $increasePerMonth;
            $this->chartData['data'][] = $cumulativeRent;
        }

        $startMonth = $num_of_months_frist_interval + 1 + $num_of_months_second_interval;
        if ($startMonth <= 12) {
            foreach (range($startMonth, 12) as $index => $month) {
                $monthName = Carbon::create()->month($month)->format('F');
                $months[] = $monthName;

                if ($index === 0) {
                    $increasePoints[] = [
                        'month' => $monthName,
                        'percentage' => round(($increasePerMonth) / ($this->initialMonthlyRent + $increasePerMonth) * 100, 2)
                    ];
                }

                $this->monthlyProjections[$monthName] = $this->initialMonthlyRent + 2 * $increasePerMonth;
                $cumulativeRent += $this->initialMonthlyRent + 2 * $increasePerMonth;
                $this->chartData['data'][] = $cumulativeRent;
            }
        }

        //  dd(            $this->chartData['data'][] = $cumulativeRent);
        // foreach (range($currentMonth, 12) as $index => $month) {
        //     $monthName = Carbon::create()->month($month)->format('F');
        //     $months[] = $monthName;

        //     if ($index == floor($remainingMonths / 3)) {
        //         $newMonthlyRent += $increasePerMonth / 2;
        //         $increasePoints[] = [
        //             'month' => $monthName,
        //             'percentage' => round(($increasePerMonth / 2) / $this->initialMonthlyRent * 100, 2)
        //         ];
        //     } elseif ($index == floor(2 * $remainingMonths / 3)) {
        //         $newMonthlyRent += $increasePerMonth / 2;
        //         $increasePoints[] = [
        //             'month' => $monthName,
        //             'percentage' => round(($increasePerMonth / 2) / $this->initialMonthlyRent * 100, 2)
        //         ];
        //     }

        //     $this->monthlyProjections[$monthName] = $newMonthlyRent;
        //     $cumulativeRent += $newMonthlyRent;
        //     $this->chartData['data'][] = $cumulativeRent;
        // }
        $this->chartData['labels'] = $months;
        $this->chartData['annotations'] = [];

        // foreach ($increasePoints as $point) {
        //     $this->chartData['annotations'][] = [
        //         'type' => 'line',
        //         'mode' => 'vertical',
        //         'scaleID' => 'x',
        //         'value' => array_search($point['month'], $months),
        //         'borderColor' => 'red',
        //         'borderWidth' => 2,
        //         'label' => [
        //             'content' => "Increase: +{$point['percentage']}%", // Label content
        //             'position' => 'top', // Position of the label
        //         'enabled' => true, // Disable the label
        //         ],
        //     'tooltip' => [
        //         'enabled' => true,
        //         'content' => "Increase: +{$point['percentage']}%", // Tooltip content
        //     ]
        //     ];
        // }
        foreach ($increasePoints as $point) {
            $this->chartData['annotations'][] = [
                'value' =>  array_search($point['month'], $months),
                'percentage' => $point['percentage']

            ];
        }


        $this->dispatch('updateChart', data: $this->chartData);
    }



    public function render()
    {
        return view('livewire.rent-planning');
    }
}
