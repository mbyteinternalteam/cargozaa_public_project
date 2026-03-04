<?php

namespace App\Livewire\Shared;

use App\Models\State;
use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class StateSelect extends Component
{
    #[Modelable]
    public int|string|null $stateId = '';

    public function render(): View
    {
        return view('livewire.shared.state-select', [
            'states' => State::query()->orderBy('name')->get(),
        ]);
    }
}
