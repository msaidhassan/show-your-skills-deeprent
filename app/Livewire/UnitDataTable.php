<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitDataTable extends Component
{
    use WithPagination;

    public $search = '';
    public $unitNames = [];
    public $selectedUnit = '';
    protected $listeners = ['selectedUnitUpdated'];

    // Important: set the pagination theme to match your UI framework

    // Helper method to paginate collections
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function paginate($items, $perPage = 3, $pageName = 'page')
    {
        $page = Paginator::resolveCurrentPage($pageName);

        $total = count($items);

        $currentPageItems = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $total,
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }



    public function render()
    {
        $jsonPath = config('filesystems.unit_data_json_path');

        if (!File::exists($jsonPath)) {
            Log::error("File not found: $jsonPath");
            return view('livewire.unit-data-table', ['units' => collect([])]);
        }

        $jsonContent = File::get($jsonPath);
        if (empty($jsonContent)) {
            Log::error("JSON file is empty: $jsonPath");
            return view('livewire.unit-data-table', ['units' => collect([])]);
        }

        $jsonData = json_decode($jsonContent, true);
        if ($jsonData === null) {
            Log::error("JSON Decoding Error: " . json_last_error_msg());
            return view('livewire.unit-data-table', ['units' => collect([])]);
        }

        $units = collect($jsonData['units']);
        $this->unitNames = $units->pluck('name')->toArray();

        if (!empty($this->search)) {
            $units = $units->filter(function ($unit) {
                return isset($unit['name']) && stripos($unit['name'], $this->search) !== false;
            });
        }

        $units = $units->sortBy('size');

        // Use the helper method to paginate
        $paginatedUnits = $this->paginate($units);

        return view('livewire.unit-data-table', [
            'units' => $paginatedUnits,
        ]);
    }

    public function clearSelection()
    {
        $this->reset(['selectedUnit', 'search']);
        $this->resetPage();
        $this->dispatch('clear-search');
    }

    public function selectedUnitUpdated($value)
    {
        $this->search = $value;
    }
}
