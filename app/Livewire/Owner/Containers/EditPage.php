<?php

namespace App\Livewire\Owner\Containers;

use App\Enums\ContainerStatus;
use App\Enums\ContainerStructure as ContainerStructureEnum;
use App\Enums\ContainerUpdateRequestStatus;
use App\Models\Config\ContainerStructure;
use App\Models\Container;
use App\Models\ContainerUpdateRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('owner.layout.app')]
#[Title('Edit Container')]
class EditPage extends Component
{
    use WithFileUploads;

    public Container $container;

    public int $imagesInputKey = 0;

    public string $title = '';

    public string $container_type = '';

    public string $container_size = '';

    public string $container_condition = '';

    public int|string|null $year_built = null;

    public ?string $last_inspection_date = null;

    public ?string $serial_number = null;

    public string $location = '';

    public ?string $full_address = null;

    public ?float $latitude = null;

    public ?float $longitude = null;

    public float|int|null $daily_rate = null;

    public float|int|null $weekly_rate = null;

    public float|int|null $monthly_rate = null;

    public float|int|null $length = null;

    public float|int|null $width = null;

    public float|int|null $height = null;

    public float|int|null $max_weight = null;

    public float|int|null $tare_weight = null;

    public float|int|null $cargo_capacity = null;

    public ?string $description = null;

    /**
     * @var array<int, string>
     */
    public array $features = [];

    /**
     * @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile>
     */
    public array $images = [];

    /**
     * @var array<int, string>
     */
    public array $existingImages = [];

    public function mount(Container $container): void
    {
        $owner = Auth::user()?->owner;

        if ($owner === null || $container->owner_id !== $owner->id) {
            abort(403);
        }

        $this->container = $container;

        $this->title = $container->title;
        $this->container_type = (string) $container->container_type;
        $this->container_size = (string) $container->container_size;
        $this->container_condition = (string) $container->container_condition;
        $this->year_built = (int) $container->year_built;
        $this->last_inspection_date = optional($container->last_inspection_date)->format('Y-m-d');
        $this->serial_number = $container->serial_number ?: null;
        $this->location = $container->full_address ?? '';
        $this->full_address = $container->full_address;
        $this->latitude = $container->latitude ? (float) $container->latitude : null;
        $this->longitude = $container->longitude ? (float) $container->longitude : null;
        $this->daily_rate = $container->daily_rate;
        $this->weekly_rate = $container->weekly_rate;
        $this->monthly_rate = $container->monthly_rate;
        $this->length = $container->length;
        $this->width = $container->width;
        $this->height = $container->height;
        $this->max_weight = $container->max_weight;
        $this->tare_weight = $container->tare_weight;
        $this->cargo_capacity = $container->cargo_capacity;
        $this->description = $container->description;
        $this->features = $container->features ?? [];
        $this->existingImages = $container->images ?? [];
    }

    public function updatedFeatures(): void
    {
        $this->resetErrorBag(['features', 'features.*']);

        if (count($this->features) <= 6) {
            return;
        }

        array_pop($this->features);
        $this->addError('features', 'Maximum 6 features allowed.');
    }

    public function updatedImages(): void
    {
        $this->resetErrorBag(['images', 'images.*']);

        if (count($this->images) <= 5) {
            return;
        }

        $this->images = array_slice($this->images, 0, 5);
        $this->imagesInputKey++;
        $this->addError('images', 'Maximum 5 images allowed.');
    }

    public function removeImage(int $index): void
    {
        if (! isset($this->images[$index])) {
            return;
        }

        unset($this->images[$index]);
        $this->images = array_values($this->images);

        $this->resetErrorBag(['images', 'images.*']);

        if ($this->images === []) {
            $this->imagesInputKey++;
        }
    }

    public function moveImage(int $from, int $to): void
    {
        $count = count($this->images);

        if ($count < 2 || $from === $to || $from < 0 || $to < 0 || $from >= $count || $to >= $count) {
            return;
        }

        $item = $this->images[$from];
        array_splice($this->images, $from, 1);
        array_splice($this->images, $to, 0, [$item]);
    }

    public function save(): mixed
    {
        $featureNames = ContainerStructure::query()
            ->active()
            ->feature()
            ->pluck('name')
            ->all();

        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'container_type' => ['required', Rule::exists('container_structures', 'id')->where('category', ContainerStructureEnum::TYPE->value)],
            'container_size' => ['required', Rule::exists('container_structures', 'id')->where('category', ContainerStructureEnum::SIZE->value)],
            'container_condition' => ['required', Rule::exists('container_structures', 'id')->where('category', ContainerStructureEnum::CONDITION->value)],
            'year_built' => ['required', 'integer', 'min:1990', 'max:'.date('Y')],
            'last_inspection_date' => ['required', 'date'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'full_address' => ['nullable', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'daily_rate' => ['required', 'numeric', 'min:0'],
            'weekly_rate' => ['nullable', 'numeric', 'min:0'],
            'monthly_rate' => ['nullable', 'numeric', 'min:0'],
            'length' => ['nullable', 'numeric', 'min:0'],
            'width' => ['nullable', 'numeric', 'min:0'],
            'height' => ['nullable', 'numeric', 'min:0'],
            'max_weight' => ['nullable', 'numeric', 'min:0'],
            'tare_weight' => ['nullable', 'numeric', 'min:0'],
            'cargo_capacity' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'features' => ['nullable', 'array', 'max:6'],
            'features.*' => ['string', Rule::in($featureNames)],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ], [
            'latitude.required' => 'Please pin the container location on the map.',
            'longitude.required' => 'Please pin the container location on the map.',
        ]);

        $owner = Auth::user()?->owner;

        if ($owner === null || $owner->id !== $this->container->owner_id) {
            abort(403);
        }

        $container = $this->container;

        $payload = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'container_type' => $validated['container_type'],
            'container_size' => $validated['container_size'],
            'container_condition' => $validated['container_condition'],
            'year_built' => (string) $validated['year_built'],
            'last_inspection_date' => $validated['last_inspection_date'],
            'serial_number' => $validated['serial_number'] ?? '',
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'full_address' => $validated['full_address'] ?? null,
            'daily_rate' => $validated['daily_rate'],
            'weekly_rate' => $validated['weekly_rate'] ?? 0,
            'monthly_rate' => $validated['monthly_rate'] ?? 0,
            'length' => $validated['length'] ?? 0,
            'width' => $validated['width'] ?? 0,
            'height' => $validated['height'] ?? 0,
            'max_weight' => $validated['max_weight'] ?? 0,
            'tare_weight' => $validated['tare_weight'] ?? 0,
            'cargo_capacity' => $validated['cargo_capacity'] ?? 0,
            'features' => $validated['features'] ?? [],
        ];

        $images = $this->existingImages;

        if ($this->images !== []) {
            $storedImages = [];

            foreach ($this->images as $image) {
                $storedImages[] = $image->store("owner_documents/{$owner->id}/containers/{$container->id}", 'public');
            }

            $images = $storedImages;
        }

        $payload['images'] = $images;

        if (in_array($container->status, [ContainerStatus::Pending, ContainerStatus::Appeal], true)) {
            $container->fill($payload);

            if ($container->status === ContainerStatus::Rejected) {
                $container->status = ContainerStatus::Pending;
                $container->status_reason = null;
            }

            $container->save();

            return redirect()
                ->route('owner.containers.show', $container)
                ->with('success', 'Container updated.');
        }

        ContainerUpdateRequest::updateOrCreate(
            [
                'container_id' => $container->id,
                'owner_id' => $owner->id,
                'status' => ContainerUpdateRequestStatus::Pending,
            ],
            [
                'data' => $payload,
                'reason' => null,
                'reviewed_by' => null,
                'reviewed_at' => null,
            ]
        );

        return redirect()
            ->route('owner.containers.show', $container)
            ->with('success', 'Changes submitted for admin approval.');
    }

    public function render(): View
    {
        $types = ContainerStructure::query()
            ->active()
            ->type()
            ->orderBy('name')
            ->get();

        $sizes = ContainerStructure::query()
            ->active()
            ->size()
            ->orderBy('name')
            ->get();

        $conditions = ContainerStructure::query()
            ->active()
            ->condition()
            ->orderBy('name')
            ->get();

        $featureOptions = ContainerStructure::query()
            ->active()
            ->feature()
            ->orderBy('name')
            ->get();

        return view('livewire.owner.containers.edit-page', compact(
            'types',
            'sizes',
            'conditions',
            'featureOptions',
        ));
    }
}
