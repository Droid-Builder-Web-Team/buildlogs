<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Ckeditor extends Component
{

    public $message;
    
    public function render()
    {
        return view('livewire.ckeditor');
    }
}
