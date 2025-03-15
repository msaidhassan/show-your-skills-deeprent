<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Unit;

class UnitManagement extends Component
{
    use WithPagination;

    public $name, $length, $width, $price, $status, $unitId;
    public $isEditMode = false;
    public $showModal = false;
    public $unitIdToDelete = null; // Ensure it's initialized as null

   // protected $paginationTheme = 'bootstrap';
//protected $queryString = ['isEditMode'];

    protected $listeners = [
        'delete-method' => 'deleteUnit'
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'length' => 'required|numeric|min:0', // Accepts floats
        'width' => 'required|numeric|min:0',  // Accepts floats
        'price' => 'required|numeric|min:0',    // Accepts floats
        'status' => 'required|in:rented,available'
    ];

    public function render()
    {
        return view('livewire.unit-management', [
            'units' => Unit::orderBy('length', 'asc')->paginate(3, ['*'], 'page')
        ]);
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }

    public function create()
    {
        $this->validate();
        Unit::create([
            'name' => $this->name,
            'length' => $this->length,
            'width' => $this->width,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Unit created successfully!');
        $this->closeModal();
       // $this->emit('refreshComponent');
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $this->unitId = $unit->id;
        $this->name = $unit->name;
        $this->length = $unit->length;
        $this->width = $unit->width;
        $this->price = $unit->price;
        $this->status = $unit->status;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function update()
    {
        $this->validate();
        $unit = Unit::findOrFail($this->unitId);
        $unit->update([
            'name' => $this->name,
            'length' => $this->length,
            'width' => $this->width,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Unit updated successfully!');
        $this->closeModal();
       // $this->emit('refreshComponent');
    }
    public function confirmDelete($unitId)
    {

        $this->unitIdToDelete = $unitId;
        $this->dispatch('show-delete-modal'); // Dispatch an event to show the modal

    }
    public function cancelDelete()
    {
        //dd('cancel');
        $this->unitIdToDelete = null; // Reset the delete confirmation
    }

    public function deleteUnit()
    {

        if ($this->unitIdToDelete) {
            Unit::find($this->unitIdToDelete)?->delete();
            session()->flash('message', 'Unit deleted successfully.');
        }

        $this->unitIdToDelete = null; // Reset after delete
    }

    public function resetFields()
    {
        $this->reset(['name', 'length', 'width', 'price', 'status', 'unitId', 'isEditMode']);
    }
}
