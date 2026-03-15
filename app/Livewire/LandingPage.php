<?php

namespace App\Livewire;

use App\Enums\ContainerStatus;
use App\Models\Config\ContainerStructure;
use App\Models\Container;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('shared.layouts.app')]
class LandingPage extends Component
{
    public string $goodsType = '';

    public string $location = '';

    public string $leaseStart = '';

    public string $leaseEnd = '';

    public function render(): View
    {
        $featuredContainers = Container::query()
            ->where('status', ContainerStatus::Active)
            ->where('unlisted', false)
            ->with('owner')
            ->latest()
            ->limit(8)
            ->get();

        $types = ContainerStructure::query()->type()->active()->orderBy('name')->get(['id', 'name']);

        return view('livewire.shared.landing-page', [
            'featuredContainers' => $featuredContainers,
            'types' => $types,
        ]);
    }

    public function search()
    {
        // Redirect to search page with current filters
        return redirect()->route('customer.search', [
            'goodsType' => $this->goodsType,
            'location' => $this->location,
            'leaseStart' => $this->leaseStart,
            'leaseEnd' => $this->leaseEnd,
        ]);


        // return view('livewire.shared.landing-page', [
        //     'featuredContainers' => $featuredContainers,
        // ]);
    }
}
