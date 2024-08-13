<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Toast extends Component
{
    public $toasts = [];

    #[On('showToast')] 
    public function showToast($message, $type)
    {
        $this->toasts[] = [
            'message' => $message,
            'type' => $type,
        ];

        // Automatically remove the toast after 3 seconds
        $this->dispatch('toast-auto-hide', ['index' => count($this->toasts) - 1]);
    }

    public function removeToast($index)
    {
        unset($this->toasts[$index]);
        $this->toasts = array_values($this->toasts); // Re-index the array
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
