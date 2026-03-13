<?php

namespace App\Livewire\Customer\explore;

use App\Enums\ContainerStatus;
use App\Models\Container;
use App\Models\Insurance;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('shared.layouts.app')]
class ContainerShowPage extends Component
{
    public Container $container;

    public int $activeImage = 0;

    public string $type = '';

    public string $size = '';

    public string $condition = '';

    public string $leaseStart = '';

    public string $leaseEnd = '';

    public ?int $selectedInsuranceId = null;

    public function mount(Container $container): void
    {
        if ($container->status !== ContainerStatus::Active || $container->unlisted) {
            abort(404);
        }

        $this->container = $container->load('owner');
        $this->leaseStart = request()->query('start', '');
        $this->leaseEnd = request()->query('end', '');

        $defaultInsurance = Insurance::query()->active()->first();
        $this->selectedInsuranceId = $defaultInsurance?->id;

        try {
            $structure = $container->getContainerStructureName();
            $this->type = $structure['type'];
            $this->size = $structure['size'];
            $this->condition = $structure['condition'];
        } catch (\Throwable) {
            //
        }
    }

    public function setActiveImage(int $index): void
    {
        $images = $this->container->images ?? [];
        $this->activeImage = max(0, min($index, count($images) - 1));
    }

    public function nextImage(): void
    {
        $count = count($this->container->images ?? []);
        if ($count > 0) {
            $this->activeImage = ($this->activeImage + 1) % $count;
        }
    }

    public function prevImage(): void
    {
        $count = count($this->container->images ?? []);
        if ($count > 0) {
            $this->activeImage = ($this->activeImage - 1 + $count) % $count;
        }
    }

    public function selectInsurance(int $id): void
    {
        $this->selectedInsuranceId = $id;
    }

    public function bookNow(): void
    {
        if (! auth()->check()) {
            $this->redirectRoute('login');

            return;
        }

        if (! $this->leaseStart || ! $this->leaseEnd) {
            $this->dispatch('toast', type: 'error', message: 'Please select lease dates.');

            return;
        }

        $this->redirectRoute('customer.orders.review', [
            'container' => $this->container->id,
            'insurance' => $this->selectedInsuranceId,
            'start' => $this->leaseStart,
            'end' => $this->leaseEnd,
        ]);
    }

    public function render(): View
    {
        $similarContainers = Container::query()
            ->where('status', ContainerStatus::Active)
            ->where('unlisted', false)
            ->where('id', '!=', $this->container->id)
            ->with('owner')
            ->limit(3)
            ->inRandomOrder()
            ->get();

        $insurances = Insurance::query()->active()->get();
        $selectedInsurance = $insurances->firstWhere('id', $this->selectedInsuranceId);

        return view('livewire.customer.explore.container-show-page', [
            'similarContainers' => $similarContainers,
            'insurances' => $insurances,
            'selectedInsurance' => $selectedInsurance,
        ]);
    }
}
