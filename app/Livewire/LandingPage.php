<?php

namespace App\Livewire;

use App\Enums\ContainerStatus;
use App\Models\Container;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('shared.layouts.app')]
class LandingPage extends Component
{
    public function render(): View
    {
        $featuredContainers = Container::query()
            ->where('status', ContainerStatus::Active)
            ->where('unlisted', false)
            ->with('owner')
            ->latest()
            ->limit(8)
            ->get();

        return view('livewire.shared.landing-page', [
            'featuredContainers' => $featuredContainers,
        ]);
    }
}
