<?php

namespace App\Livewire\Owner\Containers;

use App\Enums\ContainerStatus;
use App\Models\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('owner.layout.app')]
#[Title('My Container Listings')]
class IndexPage extends Component
{
    use WithPagination;

    public function render(): View
    {
        $owner = Auth::user()?->owner;

        if ($owner === null) {
            abort(403);
        }

        $baseQuery = Container::query()->where('owner_id', $owner->id);

        $containers = (clone $baseQuery)->latest()->paginate(12);
        $totalActive = (clone $baseQuery)->where('status', ContainerStatus::Active)->count();
        $totalPending = (clone $baseQuery)->where('status', ContainerStatus::Pending)->count();

        return view('livewire.owner.containers.index-page', compact('containers', 'totalActive', 'totalPending'));
    }
}
