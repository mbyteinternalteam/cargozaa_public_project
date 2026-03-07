<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
        <div class="breadcrumbs text-sm mb-6">
            <ul class="text-gray-500">
                <li><a class="hover:text-primary" href="{{ route('owner.containers.index') }}">My Containers</a></li>
                <li class="text-gray-700 font-medium">{{ $container->title }}</li>
            </ul>
        </div>

        @if($container->status === \App\Enums\ContainerStatus::Rejected && $container->status_reason)
            <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 flex gap-2">
                <x-heroicon-s-exclamation-triangle class="w-5 h-5 mt-0.5 text-red-500" />
                <div>
                    <p class="font-semibold mb-1">This container was rejected</p>
                    <p class="text-[13px] leading-snug">{{ $container->status_reason }}</p>
                </div>
            </div>
        @endif



        <div class="flex items-start justify-between mb-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-[#1a1a2e] text-[28px] font-bold">
                        {{ $container->title }}
                    </h1>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] border
                                 @class([
                                     'bg-green-50 text-green-700 border-green-200' => $container->status === \App\Enums\ContainerStatus::Active,
                                     'bg-amber-50 text-amber-700 border-amber-200' => $container->status === \App\Enums\ContainerStatus::Pending,
                                     'bg-gray-50 text-gray-700 border-gray-200' => ! in_array($container->status, [\App\Enums\ContainerStatus::Active, \App\Enums\ContainerStatus::Pending], true),
                                 ])">
                        <x-heroicon-s-check-circle class="w-3.5 h-3.5" />
                        {{ $container->status->label() }}
                    </span>
                </div>
                <div class="flex items-center gap-4 text-gray-500 text-[14px]">
                    <div class="flex items-center gap-1.5">
                        <x-heroicon-s-map-pin class="w-4 h-4" />
                        <p class=" overflow-hidden text-ellipsis whitespace-nowrap">{{ $container->full_address }}</p>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <x-heroicon-s-archive-box class="w-4 h-4" />
                        ID: {{ $container->display_id }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($container->status === \App\Enums\ContainerStatus::Active)
                    <button type="button"
                            wire:click="toggleUnlisted"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-[14px] font-semibold transition-colors
                                {{ $container->unlisted
                                        ? 'bg-gray-100 border-gray-300 text-gray-700 hover:bg-gray-50'
                                        : 'bg-yellow-100 border-yellow-500 text-yellow-700 hover:bg-yellow-50' }}">
                        @if($container->unlisted)
                            <x-heroicon-o-eye class="w-4 h-4" />
                            <span>Relist</span>
                        @else
                            <x-heroicon-o-eye-slash class="w-4 h-4" />
                            <span>Unlist</span>
                        @endif
                    </button>
                @endif

                @if(($container->status === \App\Enums\ContainerStatus::Active || $container->status === \App\Enums\ContainerStatus::Pending || $container->status === \App\Enums\ContainerStatus::Appeal) && !$hasPendingUpdateRequest)
                    <a href="{{ route('owner.containers.edit', $container) }}"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors text-[14px] font-semibold">
                        <x-heroicon-s-pencil-square class="w-4 h-4" />
                        Edit Details
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="rounded-2xl border border-gray-100 px-5 py-4 bg-white">
                <div class="flex items-center gap-2 mb-2 text-gray-500 text-[13px]">
                    <x-heroicon-s-calendar class="w-4 h-4 text-[#000080]" />
                    <span>Total Bookings</span>
                </div>
                <p class="text-[#000080] text-[22px] font-bold">
                    {{ $totalBookings }}
                </p>
            </div>
            <div class="rounded-2xl border border-gray-100 px-5 py-4 bg-white">
                <div class="flex items-center gap-2 mb-2 text-gray-500 text-[13px]">
                    <x-heroicon-s-currency-dollar class="w-4 h-4 text-emerald-500" />
                    <span>Total Revenue</span>
                </div>
                <p class="text-emerald-600 text-[22px] font-extrabold">
                    RM {{ number_format($totalRevenue, 2) }}
                </p>
            </div>
            <div class="rounded-2xl border border-gray-100 px-5 py-4 bg-white">
                <div class="flex items-center gap-2 mb-2 text-gray-500 text-[13px]">
                    <x-heroicon-s-arrow-trending-up class="w-4 h-4 text-[#000080]" />
                    <span>Occupancy Rate</span>
                </div>
                <p class="text-[#000080] text-[22px] font-bold">
                    {{ $occupancyRate }}%
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl border border-gray-100 p-4">
                    @if($container->images && count($container->images) > 0)
                        <div class="space-y-3">
                            <div class="relative rounded-2xl overflow-hidden">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($container->images[$activeImage] ?? $container->images[0]) }}"
                                     alt="{{ $container->title }}"
                                     class="w-full h-72 object-cover">
                                <div class="absolute top-3 right-3 px-3 py-1 rounded-full bg-white/90 text-[12px] text-gray-700 font-medium shadow-sm">
                                    {{ $activeImage + 1 }} / {{ count($container->images) }}
                                </div>
                            </div>

                            @if(count($container->images) > 1)
                                <div class="flex gap-3 overflow-x-auto pb-1">
                                    @foreach($container->images as $index => $image)
                                        <button type="button"
                                                wire:click="setActiveImage({{ $index }})"
                                                class="relative rounded-xl overflow-hidden border {{ $index === $activeImage ? 'border-primary ring-2 ring-primary/40' : 'border-gray-200' }} flex-shrink-0"
                                                style="width: 120px; height: 70px;">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($image) }}"
                                                 alt="Thumbnail {{ $index + 1 }}"
                                                 class="w-full h-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="h-72 rounded-2xl border border-dashed border-gray-200 bg-gray-50 flex items-center justify-center">
                            <x-heroicon-s-photo class="w-16 h-16 text-gray-300" />
                        </div>
                    @endif
                </div>

                <div class="rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-[#1a1a2e] text-[18px] mb-4 font-bold">
                        Specifications
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-gray-50">
                            <p class="text-gray-500 text-[12px] mb-1">Length</p>
                            <p class="text-[#1a1a2e] text-[14px] font-bold">{{ $container->length }}ft ({{ $this->convertFeetToMeters($container->length) }}m)</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50">
                            <p class="text-gray-500 text-[12px] mb-1">Width</p>
                            <p class="text-[#1a1a2e] text-[14px] font-bold">{{ $container->width }}ft ({{ $this->convertFeetToMeters($container->width) }}m)</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50">
                            <p class="text-gray-500 text-[12px] mb-1">Height</p>
                            <p class="text-[#1a1a2e] text-[14px] font-bold">{{ $container->height }}ft ({{ $this->convertFeetToMeters($container->height) }}m)</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50">
                            <p class="text-gray-500 text-[12px] mb-1">Capacity</p>
                            <p class="text-[#1a1a2e] text-[14px] font-semibold">{{ $container->cargo_capacity }} cubic meters</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gray-50">
                            <p class="text-gray-500 text-[12px] mb-1">Max Weight</p>
                            <p class="text-[#1a1a2e] text-[14px] font-semibold">
                                {{ $container->max_weight }} kg
                            </p>
                        </div>

                        <div class="p-4 rounded-xl bg-gray-50">
                            <p class="text-gray-500 text-[12px] mb-1">Tare Weight</p>
                            <p class="text-[#1a1a2e] text-[14px] font-semibold">
                                {{ $container->tare_weight }} kg
                            </p>
                        </div>
                    </div>
                </div>

                @if($container->features && count($container->features) > 0)
                    <div class="rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-[#1a1a2e] text-[18px] mb-4 font-bold">
                            Features & Amenities
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-2">
                            @foreach($container->features as $feature)
                                <div class="flex items-start gap-2 text-[14px] text-gray-700">
                                    <x-heroicon-s-check-circle class="w-4 h-4 text-emerald-500 mt-0.5" />
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="rounded-2xl border border-gray-100 p-6">
                    <h3 class="text-[#1a1a2e] text-[18px] mb-4 font-bold">
                        Requested Changes
                    </h3>
                    @if($updateRequests->isEmpty())
                        <p class="text-gray-500 text-[14px]">No change requests yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full text-[13px]">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Submitted</th>
                                        <th>Status</th>
                                        <th>Reviewed At</th>
                                        <th>Reason</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($updateRequests as $req)
                                        <tr>
                                            <td class="font-mono">{{ $req->id }}</td>
                                            <td>{{ $req->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <span class="badge badge-sm p-1
                                                    {{ $req->status->value === 'pending' ? 'badge-warning' : ($req->status->value === 'approved' ? 'badge-success' : 'badge-error') }}">
                                                    {{ ucfirst($req->status->value) }}
                                                </span>
                                            </td>
                                            <td>{{ $req->reviewed_at?->format('d M Y H:i') ?? '—' }}</td>
                                            <td class="max-w-[200px]">
                                                @php $reason = $req->reason ?? ''; $reasonLen = strlen($reason); @endphp
                                                @if($reasonLen === 0)
                                                    —
                                                @elseif($reasonLen > 50)
                                                    <span class="line-clamp-2">{{ $reason }}</span>
                                                    <button type="button" wire:click="viewReason({{ $req->id }})"
                                                        class="link link-primary link-hover text-[12px] mt-0.5">Read more</button>
                                                @else
                                                    {{ $reason }}
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" wire:click="viewRequest({{ $req->id }})"
                                                    class="btn btn-sm btn-ghost gap-1.5">
                                                    <x-heroicon-s-eye class="w-4 h-4" />
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $updateRequests->links() }}
                        </div>
                    @endif
                </div>

                @if($viewingRequest)
                    <dialog class="modal modal-open">
                        <div class="modal-box max-w-2xl max-h-[90vh] overflow-y-auto">
                            <h3 class="font-bold text-lg mb-4">Change Request #{{ $viewingRequest->id }}</h3>
                            @php $d = $viewingRequest->data ?? []; @endphp
                            <div class="space-y-4 text-[13px]">
                                @if(!empty($d['title']))
                                    <div class="flex justify-between gap-4 p-3 rounded-lg bg-gray-50">
                                        <span class="text-gray-600 shrink-0">Title</span>
                                        <span class="font-medium text-right">{{ $d['title'] }}</span>
                                    </div>
                                @endif
                                @if(!empty($d['description']))
                                    <div class="p-3 rounded-lg bg-gray-50">
                                        <span class="text-gray-600 block mb-1">Description</span>
                                        <p class="text-gray-800">{{ $d['description'] }}</p>
                                    </div>
                                @endif
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach(['container_type' => 'Type', 'container_size' => 'Size', 'container_condition' => 'Condition', 'year_built' => 'Year Built', 'serial_number' => 'Serial'] as $key => $label)
                                        @if(!empty($d[$key]))
                                            @php
                                                $val = $d[$key];
                                                if (in_array($key, ['container_type', 'container_size', 'container_condition'], true)) {
                                                    $val = \App\Models\Config\ContainerStructure::find($val)?->name ?? $val;
                                                }
                                            @endphp
                                            <div class="flex justify-between gap-2 p-3 rounded-lg bg-gray-50">
                                                <span class="text-gray-600 shrink-0">{{ $label }}</span>
                                                <span class="font-medium truncate">{{ $val }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @if(!empty($d['full_address']))
                                    <div class="p-3 rounded-lg bg-gray-50">
                                        <span class="text-gray-600 block mb-1">Address</span>
                                        <span class="text-gray-800">{{ $d['full_address'] }}</span>
                                    </div>
                                @endif
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach(['daily_rate' => 'Daily', 'weekly_rate' => 'Weekly', 'monthly_rate' => 'Monthly'] as $key => $label)
                                        @if(isset($d[$key]) && $d[$key] !== null && $d[$key] !== '')
                                            <div class="flex justify-between gap-2 p-3 rounded-lg bg-gray-50">
                                                <span class="text-gray-600">{{ $label }}</span>
                                                <span class="font-medium col-span-2">RM {{ number_format((float)$d[$key], 2) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach(['length' => 'Length (ft)', 'width' => 'Width (ft)', 'height' => 'Height (ft)', 'max_weight' => 'Max Weight (kg)', 'tare_weight' => 'Tare (kg)', 'cargo_capacity' => 'Capacity (m³)'] as $key => $label)
                                        @if(isset($d[$key]) && $d[$key] !== null && $d[$key] !== '' && $d[$key] != 0)
                                            <div class="flex justify-between gap-2 p-3 rounded-lg bg-gray-50">
                                                <span class="text-gray-600">{{ $label }}</span>
                                                <span class="font-medium">{{ $d[$key] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @if(!empty($d['features']))
                                    <div class="p-3 rounded-lg bg-gray-50">
                                        <span class="text-gray-600 block mb-2">Features</span>
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($d['features'] as $f)
                                                <span class="badge badge-sm badge-success p-1 text-white">{{ $f }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-action">
                                <button type="button" class="btn" wire:click="closeViewModal">Close</button>
                            </div>
                        </div>
                        <div class="modal-backdrop cursor-pointer" wire:click="closeViewModal"></div>
                    </dialog>
                @endif

                @if($reasonModalRequest)
                    <dialog class="modal modal-open">
                        <div class="modal-box max-w-lg">
                            <h3 class="font-bold text-lg mb-2">Reason — Request #{{ $reasonModalRequest->id }}</h3>
                            <p class="text-gray-700 text-[14px] whitespace-pre-wrap">{{ $reasonModalRequest->reason ?? '—' }}</p>
                            <div class="modal-action">
                                <button type="button" class="btn" wire:click="closeReasonModal">Close</button>
                            </div>
                        </div>
                        <div class="modal-backdrop cursor-pointer" wire:click="closeReasonModal"></div>
                    </dialog>
                @endif

                @if($container->description)
                    <div class="rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-[#1a1a2e] text-[18px] mb-4 font-bold">
                            Description
                        </h3>
                        <p class="text-gray-700 text-[14px] leading-relaxed">
                            {{ $container->description }}
                        </p>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-gray-100 p-6 sticky top-6">
                    <h3 class="text-[#1a1a2e] text-[18px] mb-4 font-bold">
                        Pricing & Availability
                    </h3>

                    <div class="mb-6">
                        <div class="flex items-baseline gap-2 mb-1">
                            <span class="text-[#000080] text-[32px] font-bold">
                                RM {{ number_format($container->daily_rate, 2) }}
                            </span>
                            <span class="text-gray-500 text-[14px]">/day</span>
                        </div>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                            <span class="text-gray-600 text-[13px]">Type</span>
                            <span class="text-[#1a1a2e] text-[13px] font-semibold">
                                {{ $type }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                            <span class="text-gray-600 text-[13px]">Size</span>
                            <span class="text-[#1a1a2e] text-[13px] font-semibold">
                                {{ $size }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                            <span class="text-gray-600 text-[13px]">Condition</span>
                            <span class="text-[#1a1a2e] text-[13px] font-semibold">
                                {{ $condition }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                            <span class="text-gray-600 text-[13px]">Year Built</span>
                            <span class="text-[#1a1a2e] text-[13px] font-semibold">
                                {{ $container->year_built }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                            <span class="text-gray-600 text-[13px]">Last Inspection</span>
                            <span class="text-[#1a1a2e] text-[13px] font-semibold">
                                {{ $container->last_inspection_date->format('d M Y') }}
                            </span>
                        </div>
                        
                    </div>

                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 text-[12px] text-blue-700">
                        This container is currently {{ $container->status->label() }} on the Cargozaa marketplace.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
