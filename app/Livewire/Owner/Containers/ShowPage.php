<?php

namespace App\Livewire\Owner\Containers;

use App\Enums\ContainerUpdateRequestStatus;
use App\Models\Container;
use App\Models\ContainerUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('owner.layout.app')]
class ShowPage extends Component
{
    use WithPagination;

    public Container $container;

    public int $activeImage = 0;

    public int $totalBookings = 0;

    public float $totalRevenue = 0.0;

    public int $occupancyRate = 0;

    public ?int $viewingRequestId = null;

    public ?int $reasonModalRequestId = null;

    public string $type = '';

    public string $size = '';

    public string $condition = '';

    public function mount(Container $container): void
    {
        $owner = Auth::user()?->owner;

        if ($owner === null || $container->owner_id !== $owner->id) {
            abort(403);
        }

        $this->container = $container;

        // if($container->container_type !== null && $container->container_size !== null && $container->container_condition !== null) {

        $containerStructure = $container->getContainerStructureName();
        $this->type = $containerStructure['type'];
        $this->size = $containerStructure['size'];
        $this->condition = $containerStructure['condition'];
        // }
    }

    public function viewReason(int $id): void
    {
        $req = ContainerUpdateRequest::query()
            ->where('container_id', $this->container->id)
            ->find($id);
        $this->reasonModalRequestId = $req?->id;
    }

    public function closeReasonModal(): void
    {
        $this->reasonModalRequestId = null;
    }

    public function viewRequest(int $id): void
    {
        $req = ContainerUpdateRequest::query()
            ->where('container_id', $this->container->id)
            ->find($id);

        $this->viewingRequestId = $req?->id;
    }

    public function closeViewModal(): void
    {
        $this->viewingRequestId = null;
    }

    public function render(): View
    {
        $updateRequests = ContainerUpdateRequest::query()
            ->where('container_id', $this->container->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        $viewingRequest = $this->viewingRequestId
            ? ContainerUpdateRequest::query()
                ->where('container_id', $this->container->id)
                ->find($this->viewingRequestId)
            : null;

        $reasonModalRequest = $this->reasonModalRequestId
            ? ContainerUpdateRequest::query()
                ->where('container_id', $this->container->id)
                ->find($this->reasonModalRequestId)
            : null;

        $hasPendingUpdateRequest = ContainerUpdateRequest::query()
            ->where('container_id', $this->container->id)
            ->orderByDesc('created_at')
            ->value('status') === ContainerUpdateRequestStatus::Pending->value;

        return view('livewire.owner.containers.show-page', compact('updateRequests', 'viewingRequest', 'reasonModalRequest', 'hasPendingUpdateRequest'));
    }

    public function setActiveImage(int $index): void
    {
        $images = $this->container->images ?? [];

        if (! is_array($images)) {
            return;
        }

        $count = count($images);

        if ($index < 0 || $index >= $count) {
            return;
        }

        $this->activeImage = $index;
    }

    public function toggleUnlisted(): void
    {
        $owner = Auth::user()?->owner;

        if (! $owner || $owner->id !== $this->container->owner_id) {
            abort(403);
        }

        $this->container->unlisted = ! (bool) $this->container->unlisted;
        $this->container->save();
    }

    public function convertFeetToMeters(int $feet): int
    {
        return $feet * 0.3048;
    }
}
