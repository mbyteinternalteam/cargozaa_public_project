<?php

namespace App\Livewire\Customer\explore;

use App\Enums\ContainerStatus;
use App\Models\Config\ContainerStructure;
use App\Models\Container;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('shared.layouts.app')]
class SearchPage extends Component
{
    use WithPagination;

    public string $goodsType = '';

    public string $location = '';

    public string $leaseStart = '';

    public string $leaseEnd = '';

    public string $containerType = '';

    public string $selectedLocation = '';

    public string $selectedLeaseStart = '';

    public string $selectedLeaseEnd = '';

    public string $selectedSize = '';

    public ?float $priceMin = null;

    public ?float $priceMax = null;

    public bool $gps = false;

    public bool $insured = false;

    public bool $tempControl = false;

    public string $sortBy = 'relevance';

    public string $viewMode = 'grid';

    public function setViewMode(string $mode): void
    {
        $this->viewMode = in_array($mode, ['grid', 'list'], true) ? $mode : 'grid';
    }

    public function search(): void
    {
        $this->containerType = $this->goodsType;
        $this->selectedLocation = $this->location;
        $this->selectedLeaseStart = $this->leaseStart;
        $this->selectedLeaseEnd = $this->leaseEnd;
        $this->applyFilters();
        $this->resetPage();
    }

    public function applyFilters(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->goodsType = '';
        $this->location = '';
        $this->leaseStart = '';
        $this->leaseEnd = '';
        $this->containerType = '';
        $this->selectedLocation = '';
        $this->selectedLeaseStart = '';
        $this->selectedLeaseEnd = '';
        $this->selectedSize = '';
        $this->priceMin = null;
        $this->priceMax = null;
        $this->gps = false;
        $this->insured = false;
        $this->tempControl = false;
        $this->sortBy = 'relevance';
        $this->resetPage();
    }

    public function render(): View
    {
        $query = Container::query()
            ->where('status', ContainerStatus::Active)
            ->where('unlisted', false)
            ->with('owner');

        if ($this->containerType) {
            $typeId = ContainerStructure::query()->type()->where('name', $this->containerType)->value('id');
            if ($typeId) {
                $query->where('container_type', $typeId);
            }
        }

        if ($this->selectedLocation) {
            $query->where(function ($q) {
                // $q->where('location', 'like', '%'.$this->selectedLocation.'%')
                $q->where('full_address', 'like', '%'.$this->selectedLocation.'%');
            });
        }

        if ($this->selectedSize) {
            $sizeId = ContainerStructure::query()->size()->where('name', $this->selectedSize)->value('id');
            if ($sizeId) {
                $query->where('container_size', $sizeId);
            }
        }

        if ($this->priceMin !== null && $this->priceMin > 0) {
            $query->where('daily_markup', '>=', $this->priceMin);
        }
        if ($this->priceMax !== null && $this->priceMax > 0) {
            $query->where('daily_markup', '<=', $this->priceMax);
        }

        if ($this->gps) {
            $query->whereNotNull('latitude')->whereNotNull('longitude');
        }

        $query->when($this->sortBy === 'price-low', fn ($q) => $q->orderBy('daily_rate'))
            ->when($this->sortBy === 'price-high', fn ($q) => $q->orderByDesc('daily_rate'))
            ->when($this->sortBy === 'relevance', fn ($q) => $q->latest());

        $containers = $query->paginate(12);
        $types = ContainerStructure::query()->type()->active()->orderBy('name')->get(['id', 'name']);
        $sizes = ContainerStructure::query()->size()->active()->orderBy('name')->get(['id', 'name']);

        return view('livewire.customer.explore.search-page', compact('containers', 'types', 'sizes'));
    }
}
