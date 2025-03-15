<?php

use App\Livewire\SuccessNotificationButton;
use App\Livewire\PageToggleOne;
use App\Livewire\PageToggleTwo;
use App\Livewire\UnitDataTable;
use App\Livewire\UnitSizeFilter;
use App\Livewire\MetricConverter;
use App\Livewire\ProratedCalculator;
use App\Livewire\UnitManagement;
use App\Livewire\RentPlanning;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/success-notification-button', SuccessNotificationButton::class);

Route::get('/page-one', PageToggleOne::class)->name('page.one');
Route::get('/page-two', PageToggleTwo::class)->name('page.two');

Route::get('/unit-data-table', UnitDataTable::class);
Route::get('/unit-size-filter', UnitSizeFilter::class);
Route::get('/metric-converter', MetricConverter::class);
Route::get('/prorated-calculator', ProratedCalculator::class);
Route::get('/unit-management', UnitManagement::class);
Route::get('/rent-planning', RentPlanning::class);

