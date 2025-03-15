<?php

namespace App\Livewire;

use Livewire\Component;

class SuccessNotificationButton extends Component
{
    public $loading = false;
    public $success = false;

    public function showSuccess()
    {
        $this->loading = true;
        $this->success = false;

        // Simulate a 2-second delay
        sleep(2);

        $this->loading = false;
        $this->success = true;

    }

    public function render()
    {
        return view('livewire.success-notification-button');
    }
}
