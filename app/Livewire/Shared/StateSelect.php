<?php

namespace App\Livewire\Shared;

use App\Models\State;
use Illuminate\View\View;
use Livewire\Component;

class StateSelect extends Component
{
    public function render(): View
    {
        return view('livewire.shared.state-select', [
            'states' => State::query()->orderBy('name')->get(),
        ]);
    }
}
