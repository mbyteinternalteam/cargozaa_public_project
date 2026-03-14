@php
    $images = $container->images ?? [];
    $imageCount = count($images);
    $hasGps = $container->latitude && $container->longitude;
    $ownerInitials = collect(explode(' ', $container->owner?->business_name ?? 'O'))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->join('');
    // Use markup as final customer price; fallback to base rate
    $dailyRate = (float) ($container->daily_markup ?: $container->daily_rate);
    $monthlyRate = (float) ($container->monthly_markup ?: $container->monthly_rate);
@endphp

<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-[13px] text-gray-400 mb-6">
            <a href="{{ route('customer.search') }}" class="hover:text-[#000080] transition-colors">Containers</a>
            <x-heroicon-s-chevron-right class="w-3 h-3" />
            <span class="text-[#1a1a2e]">{{ $type ? "$size $type" : $container->title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Left: Gallery + Details --}}
            <div class="lg:col-span-2">
                {{-- Photo Gallery --}}
                @if($imageCount > 0)
                    <div class="relative rounded-2xl overflow-hidden mb-4">
                        <div class="aspect-[16/9] relative">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($images[$activeImage] ?? $images[0]) }}"
                                 alt="{{ $container->title }}"
                                 class="w-full h-full object-cover">
                            @if($imageCount > 1)
                                <button wire:click="prevImage" type="button"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center hover:bg-white transition shadow-md">
                                    <x-heroicon-s-chevron-left class="w-5 h-5 text-gray-700" />
                                </button>
                                <button wire:click="nextImage" type="button"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center hover:bg-white transition shadow-md">
                                    <x-heroicon-s-chevron-right class="w-5 h-5 text-gray-700" />
                                </button>
                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                                    @foreach($images as $i => $img)
                                        <button wire:click="setActiveImage({{ $i }})" type="button"
                                            class="w-2.5 h-2.5 rounded-full transition-all {{ $i === $activeImage ? 'bg-white scale-110' : 'bg-white/50' }}"></button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- Thumbnails --}}
                    @if($imageCount > 1)
                        <div class="grid grid-cols-4 gap-3 mb-8">
                            @foreach($images as $i => $img)
                                <button wire:click="setActiveImage({{ $i }})" type="button"
                                    class="rounded-xl overflow-hidden border-2 transition-all {{ $i === $activeImage ? 'border-[#000080]' : 'border-transparent hover:border-gray-200' }}">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($img) }}" alt="" class="w-full h-20 object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="aspect-[16/9] rounded-2xl border border-dashed border-gray-200 bg-gray-50 flex items-center justify-center mb-8">
                        <x-heroicon-s-cube class="w-16 h-16 text-gray-300" />
                    </div>
                @endif

                {{-- Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-0.5 bg-green-50 text-green-600 rounded-full text-[12px] font-semibold">Available Now</span>
                            @if($size)
                                <span class="px-2.5 py-0.5 bg-[#000080]/5 text-[#000080] rounded-full text-[12px] font-semibold">{{ $size }}</span>
                            @endif
                        </div>
                        <h1 class="text-[#1a1a2e] text-[28px] font-bold">
                            {{ $container->title }}
                        </h1>
                        <div class="flex items-center gap-3 mt-2">
                            @if($container->full_address || $container->location)
                                <div class="flex items-start gap-1 text-gray-500">
                                    <x-heroicon-s-map-pin class="w-5 h-5 pt-1" />
                                    <span class="text-[14px]">{{ $container->location ?? Str::limit($container->full_address, 150) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($container->description)
                    <p class="text-gray-500 text-[15px] leading-relaxed mb-8">{{ $container->description }}</p>
                @endif

                {{-- Specifications --}}
                <div class="mb-8">
                    <h2 class="text-[#1a1a2e] text-[20px] font-semibold mb-5">Specifications</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if($container->length && $container->width && $container->height)
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <x-heroicon-s-arrows-pointing-out class="w-5 h-5 text-[#000080] mb-2" />
                                <div class="text-[12px] text-gray-400 font-medium mb-0.5">External Size</div>
                                <div class="text-[14px] text-[#1a1a2e] font-semibold">{{ $container->length }}m x {{ $container->width }}m x {{ $container->height }}m</div>
                            </div>
                        @endif
                        @if($container->cargo_capacity)
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <x-heroicon-s-cube class="w-5 h-5 text-[#000080] mb-2" />
                                <div class="text-[12px] text-gray-400 font-medium mb-0.5">Internal Volume</div>
                                <div class="text-[14px] text-[#1a1a2e] font-semibold">{{ $container->cargo_capacity }} m³</div>
                            </div>
                        @endif
                        @if($container->max_weight)
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <x-heroicon-s-scale class="w-5 h-5 text-[#000080] mb-2" />
                                <div class="text-[12px] text-gray-400 font-medium mb-0.5">Max Payload</div>
                                <div class="text-[14px] text-[#1a1a2e] font-semibold">{{ number_format($container->max_weight, 0) }} kg</div>
                            </div>
                        @endif
                        @if($type)
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                                <x-heroicon-s-fire class="w-5 h-5 text-[#000080] mb-2" />
                                <div class="text-[12px] text-gray-400 font-medium mb-0.5">Type</div>
                                <div class="text-[14px] text-[#1a1a2e] font-semibold">{{ $type }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Features --}}
                @if($container->features && count($container->features) > 0)
                    <div class="mb-8">
                        <h2 class="text-[#1a1a2e] text-[20px] font-semibold mb-5">Features</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($container->features as $feature)
                                <div class="flex items-center gap-3">
                                    <x-heroicon-s-check-circle class="w-5 h-5 text-[#000080] shrink-0" />
                                    <span class="text-[14px] text-gray-600">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- GPS Tracking Preview --}}
                @if($hasGps)
                    <div class="mb-8">
                        <h2 class="text-[#1a1a2e] text-[20px] font-semibold mb-5">GPS Tracking Preview</h2>
                        <div class="rounded-2xl overflow-hidden border border-gray-200 bg-gray-100 h-72 relative">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-16 h-16 rounded-full bg-[#000080]/10 flex items-center justify-center mx-auto mb-3">
                                        <x-heroicon-s-signal class="w-8 h-8 text-[#000080]" />
                                    </div>
                                    <p class="text-[#1a1a2e] text-[15px] font-semibold">Live GPS Tracking</p>
                                    <p class="text-gray-500 text-[13px]">{{ $container->location ?? Str::limit($container->full_address, 30) }}</p>
                                </div>
                            </div>
                            <svg class="absolute inset-0 w-full h-full opacity-10">
                                <defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="#000080" stroke-width="1" /></pattern></defs>
                                <rect width="100%" height="100%" fill="url(#grid)" />
                            </svg>
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                <div class="relative">
                                    <div class="w-6 h-6 rounded-full bg-[#000080] border-[3px] border-white shadow-lg"></div>
                                    <div class="absolute -inset-3 rounded-full bg-[#000080]/20 animate-ping"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Owner Info --}}
                {{-- <div class="mb-8 p-6 rounded-2xl border border-gray-100">
                    <h2 class="text-[#1a1a2e] text-[20px] font-semibold mb-4">Owner</h2>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-[#000080] flex items-center justify-center text-white text-[18px] font-bold shrink-0">
                            {{ $ownerInitials }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#1a1a2e] text-[16px] font-semibold">{{ $container->owner?->business_name ?? 'Owner' }}</span>
                                <x-heroicon-s-check-badge class="w-5 h-5 text-[#000080]" />
                            </div>
                            <p class="text-gray-500 text-[13px]">Verified Owner · {{ $container->owner?->containers()->count() ?? 0 }} containers listed</p>
                        </div>
                    </div>
                </div> --}}

                {{-- Similar Containers --}}
                @if($similarContainers->count() > 0)
                    <div>
                        <h2 class="text-[#1a1a2e] text-[20px] font-semibold mb-5">Similar Containers</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($similarContainers as $sc)
                                @php
                                    try {
                                        $scStruct = $sc->getContainerStructureName();
                                        $scType = $scStruct['type'] ?? $sc->title;
                                        $scSize = $scStruct['size'] ?? '';
                                    } catch (\Throwable) {
                                        $scType = $sc->title;
                                        $scSize = '';
                                    }
                                @endphp
                                <a href="{{ route('customer.containers.show', $sc) }}" wire:key="similar-{{ $sc->id }}"
                                   class="group rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition-all">
                                    <div class="h-32 overflow-hidden">
                                        @if($sc->images && count($sc->images) > 0)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($sc->images[0]) }}" alt="{{ $scType }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                <x-heroicon-s-cube class="w-10 h-10 text-gray-300" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h4 class="text-[#1a1a2e] text-[14px] font-semibold truncate">{{ $scType }} {{ $scSize ? "- $scSize" : '' }}</h4>
                                        <div class="flex items-center gap-1 mt-1 text-gray-400 text-[12px]">
                                            <x-heroicon-s-map-pin class="w-3 h-3" />
                                            <span class="truncate">{{ $sc->location ?? Str::limit($sc->full_address, 25) ?? '—' }}</span>
                                        </div>
                                        @php
                                            $scDailyPrice = (float) ($sc->daily_markup ?: $sc->daily_rate);
                                        @endphp
                                        <div class="flex items-center justify-between mt-3">
                                            <span class="text-[#000080] font-bold">RM {{ number_format($scDailyPrice, 0) }}/day</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right: Booking Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-[90px]">
                    <div class="rounded-2xl border border-gray-200 p-6 shadow-sm">
                        {{-- Price --}}
                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-[#000080] text-[32px] font-bold">RM {{ number_format($dailyRate, 0) }}</span>
                                <span class="text-gray-400 text-[15px]">/day</span>
                            </div>
                            @if($monthlyRate > 0)
                                <p class="text-gray-500 text-[13px]">RM {{ number_format($monthlyRate, 0) }} /month</p>
                            @endif
                        </div>

                        {{-- Lease Period --}}
                        <div x-data="{
                                start: @entangle('leaseStart'),
                                end: @entangle('leaseEnd'),
                                openCal: false,
                                onRangeChange(e) {
                                    const val = e.target.value || '';
                                    const [s, en] = val.split('/');
                                    this.start = s || '';
                                    this.end = en || '';
                                    $wire.set('leaseStart', this.start);
                                    $wire.set('leaseEnd', this.end);
                                    if (this.start && this.end) this.openCal = false;
                                }
                            }" class="mb-4 relative">
                            {{-- Empty dates indicator --}}
                            <div x-show="!start || !end" x-transition
                                class="flex items-center gap-2 px-3 py-2 mb-2 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-[13px]">
                                <x-heroicon-s-exclamation-triangle class="w-4 h-4 shrink-0" />
                                <span>Please select your lease dates to proceed</span>
                            </div>
                            <button type="button" @click="openCal = !openCal"
                                class="w-full grid grid-cols-2 gap-0 rounded-xl border overflow-hidden text-left transition-colors"
                                :class="(!start || !end) ? 'border-amber-300 ring-2 ring-amber-100' : 'border-gray-200'">
                                <div class="p-3 border-r border-gray-200">
                                    <span class="text-[11px] text-gray-400 block mb-1 font-semibold uppercase">Start Date</span>
                                    <span class="text-[14px] font-medium" x-text="start || 'Select'" :class="start ? 'text-[#1a1a2e]' : 'text-gray-400'"></span>
                                </div>
                                <div class="p-3">
                                    <span class="text-[11px] text-gray-400 block mb-1 font-semibold uppercase">End Date</span>
                                    <span class="text-[14px] font-medium" x-text="end || 'Select'" :class="end ? 'text-[#1a1a2e]' : 'text-gray-400'"></span>
                                </div>
                            </button>
                            <div x-show="openCal" x-transition @click.outside="openCal = false" class="absolute left-0 right-0 top-full mt-1 z-50 flex justify-center">
                                <calendar-range
                                    class="cally bg-base-100 border border-gray-200 shadow-lg rounded-box"
                                    :value="(start && end) ? start + '/' + end : ''"
                                    min="{{ now()->format('Y-m-d') }}"
                                    @change="onRangeChange($event)">
                                    <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.75 19.5 8.25 12l7.5-7.5"></path></svg>
                                    <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path></svg>
                                    <calendar-month></calendar-month>
                                </calendar-range>
                            </div>
                        </div>

                        {{-- Insurance --}}
                        <div class="mb-6">
                            <label class="text-[12px] text-gray-400 mb-2 block font-semibold uppercase">Insurance</label>
                            <div class="space-y-2">
                                @foreach($insurances as $ins)
                                    <button type="button" wire:click="selectInsurance({{ $ins->id }})" wire:key="ins-{{ $ins->id }}"
                                        class="w-full p-3 rounded-xl border text-left transition-all {{ $selectedInsuranceId === $ins->id ? 'border-[#000080] bg-[#000080]/5' : 'border-gray-200 hover:border-gray-300' }}">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[14px] text-[#1a1a2e] font-semibold">{{ $ins->name }}</span>
                                            <span class="text-[13px] text-[#000080] font-semibold">
                                                {{ $ins->daily_rate > 0 ? 'RM ' . number_format($ins->daily_rate, 0) . '/day' : 'Free' }}
                                            </span>
                                        </div>
                                        <p class="text-[12px] text-gray-400 mt-0.5">{{ $ins->description }}</p>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price Breakdown --}}
                        @php
                            $insuranceRate = (float) ($selectedInsurance?->daily_rate ?? 0);
                            $leaseDays = ($leaseStart && $leaseEnd) ? max(1, \Carbon\Carbon::parse($leaseStart)->diffInDays(\Carbon\Carbon::parse($leaseEnd))) : 30;
                            $leaseTotal = $dailyRate * $leaseDays;
                            $insuranceTotal = $insuranceRate * $leaseDays;
                            $serviceFee = round(($leaseTotal + $insuranceTotal) * 0.05, 2);
                            $grandTotal = $leaseTotal + $insuranceTotal + $serviceFee;
                        @endphp
                        <div class="border-t border-gray-100 pt-4 mb-6 space-y-2">
                            <div class="flex justify-between text-[14px]">
                                <span class="text-gray-500">Container lease ({{ $leaseDays }} days)</span>
                                <span class="text-[#1a1a2e] font-medium">RM {{ number_format($leaseTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-[14px]">
                                <span class="text-gray-500">Insurance ({{ $selectedInsurance?->name ?? 'None' }})</span>
                                <span class="text-[#1a1a2e] font-medium">RM {{ number_format($insuranceTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-[14px]">
                                <span class="text-gray-500">Service fee</span>
                                <span class="text-[#1a1a2e] font-medium">RM {{ number_format($serviceFee, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-[16px] pt-2 border-t border-gray-100">
                                <span class="font-semibold">Total</span>
                                <span class="text-[#000080] font-bold">RM {{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>

                        {{-- Book Now --}}
                        <button type="button" wire:click="bookNow"
                           class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-[#000080] text-white hover:bg-[#000060] transition-all text-[15px] font-semibold">
                            <span wire:loading.remove wire:target="bookNow">
                                {{ auth()->check() ? 'Book Now' : 'Sign in to Book' }}
                            </span>
                            <span wire:loading wire:target="bookNow">Processing...</span>
                            <x-heroicon-s-arrow-right class="w-4 h-4" />
                        </button>
                        <p class="text-center text-gray-400 text-[12px] mt-3">You won't be charged yet</p>

                        {{-- Features --}}
                        <div class="mt-6 pt-4 border-t border-gray-100 space-y-3">
                            @if($hasGps)
                                <div class="flex items-center gap-3">
                                    <x-heroicon-s-signal class="w-4 h-4 text-[#000080]" />
                                    <span class="text-[13px] text-gray-600">GPS tracked 24/7</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-3">
                                <x-heroicon-s-shield-check class="w-4 h-4 text-[#000080]" />
                                <span class="text-[13px] text-gray-600">Insurance available</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-heroicon-s-calendar class="w-4 h-4 text-[#000080]" />
                                <span class="text-[13px] text-gray-600">Flexible lease terms</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-heroicon-s-check-badge class="w-4 h-4 text-[#000080]" />
                                <span class="text-[13px] text-gray-600">Verified owner</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
