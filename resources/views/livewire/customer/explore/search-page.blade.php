<div class="bg-white min-h-screen" x-data="{ showFilters: window.matchMedia('(min-width: 1024px)').matches, favorites: [], heroReady: false }" x-init="setTimeout(() => heroReady = true, 80)">
    {{-- Search Bar --}}
    <div class="bg-gradient-to-b from-gray-50 to-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
            <div class="mb-6">
                <h1 class="text-[#1a1a2e] text-[28px] font-bold mb-2 transition-all duration-700 ease-out"
                    :class="heroReady ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                    style="transition-delay: 0ms">Find Your Container</h1>
                <p class="text-gray-500 text-[15px] transition-all duration-700 ease-out"
                   :class="heroReady ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                   style="transition-delay: 100ms">Browse {{ $containers->total() }} containers across Malaysia</p>
            </div>

            <div class="bg-white rounded-2xl p-2 shadow-lg border border-gray-100 transition-all duration-700 ease-out"
                 :class="heroReady ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                 style="transition-delay: 200ms">
                <form wire:submit="search" class="grid grid-cols-1 md:grid-cols-[1fr_1.5fr_1fr_auto] gap-0 items-center">
                    <div class="p-3 md:border-r border-gray-100">
                        <label class="text-[11px] text-gray-500 mb-1 block font-semibold uppercase tracking-wider">Goods Type</label>
                        <details class="dropdown w-full" x-data x-on:click.outside="$el.removeAttribute('open')">
                            <summary class="flex items-center gap-2 cursor-pointer list-none text-[14px] text-gray-900 font-medium w-full [&::-webkit-details-marker]:hidden">
                                <x-heroicon-s-archive-box class="w-4 h-4 text-[#FFD700] flex-shrink-0" />
                                <span class="truncate">{{ $goodsType ?: 'Select type...' }}</span>
                                <x-heroicon-s-chevron-down class="w-3 h-3 ml-auto text-gray-400 flex-shrink-0" />
                            </summary>
                            <ul class="dropdown-content menu bg-base-100 rounded-box z-50 w-full min-w-48 p-2 shadow-lg border border-gray-100 mt-2">
                                <li><a @click="$wire.set('goodsType', ''); $el.closest('details').removeAttribute('open')" class="{{ !$goodsType ? 'bg-yellow-600/10 text-yellow-800 font-semibold' : '' }}">Select type...</a></li>
                                @foreach($types as $t)
                                    <li><a @click="$wire.set('goodsType', '{{ $t->name }}'); $el.closest('details').removeAttribute('open')" class="{{ $goodsType === $t->name ? 'bg-yellow-600/10 text-yellow-800 font-semibold' : '' }}">{{ $t->name }}</a></li>
                                @endforeach
                            </ul>
                        </details>
                    </div>
                    <div class="p-3 md:border-r border-gray-100 relative"
                        x-data="{
                            query: @entangle('location'),
                            suggestions: [],
                            showSuggestions: false,
                            loading: false,
                            timeout: null,
                            fetchSuggestions() {
                                clearTimeout(this.timeout);
                                if (this.query.length < 2) { this.suggestions = []; this.showSuggestions = false; return; }
                                this.timeout = setTimeout(async () => {
                                    this.loading = true;
                                    try {
                                        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&countrycodes=my&limit=5&q=${encodeURIComponent(this.query)}`, { headers: { 'Accept': 'application/json' } });
                                        const data = await res.json();
                                        this.suggestions = data.map(d => {
                                            const parts = d.display_name.split(',').map(s => s.trim());
                                            return { short: parts.slice(0, 3).join(', '), full: d.display_name };
                                        });
                                        this.showSuggestions = this.suggestions.length > 0;
                                    } catch { this.suggestions = []; }
                                    this.loading = false;
                                }, 300);
                            },
                            select(item) {
                                this.query = item.short;
                                $wire.set('location', item.short);
                                this.showSuggestions = false;
                            }
                        }"
                        @click.outside="showSuggestions = false">
                        <label class="text-[11px] text-gray-500 mb-1 block font-semibold uppercase tracking-wider">Location</label>
                        <div class="flex items-center gap-2">
                            <x-heroicon-s-map-pin class="w-4 h-4 text-[#FFD700] flex-shrink-0" />
                            <input type="text" x-model="query" @input="fetchSuggestions()" @focus="if(suggestions.length) showSuggestions = true"
                                placeholder="City or port..."
                                class="bg-transparent text-[14px] text-gray-900 w-full outline-none placeholder:text-gray-400 font-medium" />
                            <svg x-show="loading" class="w-4 h-4 animate-spin text-[#FFD700] flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        </div>
                        <ul x-show="showSuggestions" x-transition class="absolute left-0 right-0 top-full mt-1 bg-base-100 rounded-box z-50 p-2 shadow-lg border border-gray-100 max-h-48 overflow-y-auto">
                            <template x-for="(item, idx) in suggestions" :key="idx">
                                <li @click="select(item)" class="px-3 py-2 rounded-lg text-[14px] text-gray-700 hover:bg-[#000080]/5 hover:text-[#000080] cursor-pointer transition-colors flex items-center gap-2">
                                    <x-heroicon-s-map-pin class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" />
                                    <span x-text="item.short" class="truncate"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div class="p-3 md:border-r border-gray-100 relative"
                        x-data="{
                            start: @entangle('leaseStart'),
                            end: @entangle('leaseEnd'),
                            open: false,
                            get label() {
                                if (this.start && this.end) return this.formatDate(this.start) + ' → ' + this.formatDate(this.end);
                                if (this.start) return this.formatDate(this.start) + ' → ...';
                                return 'Select dates...';
                            },
                            formatDate(d) {
                                const dt = new Date(d + 'T00:00:00');
                                return dt.toLocaleDateString('en-MY', { day: 'numeric', month: 'short' });
                            },
                            onRangeChange(e) {
                                const val = e.target.value || '';
                                const [s, en] = val.split('/');
                                this.start = s || '';
                                this.end = en || '';
                                $wire.set('leaseStart', this.start);
                                $wire.set('leaseEnd', this.end);
                                if (this.start && this.end) this.open = false;
                            }
                        }"
                        @click.outside="open = false">
                        <label class="text-[11px] text-gray-500 mb-1 block font-semibold uppercase tracking-wider">Lease Period</label>
                        <button type="button" @click="open = !open" class="flex items-center gap-2 text-[14px] text-gray-900 font-medium w-full">
                            <x-heroicon-s-calendar class="w-4 h-4 text-[#FFD700] flex-shrink-0" />
                            <span class="truncate" x-text="label"></span>
                            <x-heroicon-s-chevron-down class="w-3 h-3 ml-auto text-gray-400 flex-shrink-0" />
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 top-full mt-1 z-50">
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
                    <div class="p-2 flex items-center">
                        <button type="submit" class="flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#000080] text-white hover:bg-[#000060] transition-colors text-[14px] font-semibold">
                            <x-heroicon-s-magnifying-glass class="w-4 h-4" /> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8" x-data="{ resultsInView: false }" x-intersect.once="resultsInView = true">
        <div class="flex gap-8">
            {{-- Filter Panel --}}
            <aside x-show="showFilters" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0 -translate-x-4"
                class="flex-shrink-0 overflow-hidden"
                :class="showFilters ? 'w-[280px]' : 'w-0'"
                x-cloak>
                <div class="w-[280px] sticky top-[90px] space-y-6 transition-all duration-600 ease-out"
                     :class="resultsInView ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-4'"
                     style="transition-delay: 0ms">
                    <div class="flex items-center justify-between">
                        <h3 class="text-[#1a1a2e] text-[16px] font-semibold">Filters</h3>
                        <button @click="showFilters = false" type="button" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors">
                            <x-heroicon-s-x-mark class="w-4 h-4 text-gray-400" />
                        </button>
                    </div>

                    <form wire:submit="applyFilters" class="space-y-6">
                        <div>
                            <label class="text-[13px] text-gray-500 mb-2 block font-semibold uppercase tracking-wider">Container Type</label>
                            <div class="space-y-1">
                                <button type="button" wire:click="$set('containerType', '')"
                                    class="w-full text-left px-3 py-2 rounded-lg text-[14px] transition-colors {{ !$containerType ? 'bg-[#000080]/5 text-[#000080] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                    All Types
                                </button>
                                @foreach($types as $t)
                                    <button type="button" wire:click="$set('containerType', '{{ $t->name }}')"
                                        class="w-full text-left px-3 py-2 rounded-lg text-[14px] transition-colors {{ $containerType === $t->name ? 'bg-[#000080]/5 text-[#000080] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                        {{ $t->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div x-data="{
                                sq: @entangle('selectedLocation'),
                                results: [],
                                open: false,
                                busy: false,
                                timer: null,
                                search() {
                                    clearTimeout(this.timer);
                                    if (this.sq.length < 2) { this.results = []; this.open = false; return; }
                                    this.timer = setTimeout(async () => {
                                        this.busy = true;
                                        try {
                                            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&countrycodes=my&limit=5&q=${encodeURIComponent(this.sq)}`, { headers: { 'Accept': 'application/json' } });
                                            const data = await res.json();
                                            this.results = data.map(d => d.display_name.split(',').slice(0, 3).map(s => s.trim()).join(', '));
                                            this.open = this.results.length > 0;
                                        } catch { this.results = []; }
                                        this.busy = false;
                                    }, 300);
                                },
                                pick(val) { this.sq = val; $wire.set('selectedLocation', val); this.open = false; }
                            }" @click.outside="open = false" class="relative">
                            <label class="text-[13px] text-gray-500 mb-2 block font-semibold uppercase tracking-wider">Location</label>
                            <div class="relative">
                                <x-heroicon-s-map-pin class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" />
                                <input type="text" x-model="sq" @input="search()" @focus="if(results.length) open = true"
                                    placeholder="Search location..."
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-[14px] outline-none focus:border-[#000080] transition-colors" />
                            </div>
                            <ul x-show="open" x-transition class="absolute left-0 right-0 top-full mt-1 bg-base-100 rounded-box z-50 p-2 shadow-lg border border-gray-100 max-h-40 overflow-y-auto">
                                <template x-for="(r, i) in results" :key="i">
                                    <li @click="pick(r)" class="px-3 py-2 rounded-lg text-[13px] text-gray-600 hover:bg-[#000080]/5 hover:text-[#000080] cursor-pointer transition-colors truncate" x-text="r"></li>
                                </template>
                            </ul>
                        </div>

                        <div>
                            <label class="text-[13px] text-gray-500 mb-2 block font-semibold uppercase tracking-wider">Size</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($sizes as $s)
                                    <button type="button" wire:click="$set('selectedSize', '{{ $selectedSize === $s->name ? '' : $s->name }}')"
                                        class="px-3 py-1.5 rounded-lg border text-[13px] transition-colors {{ $selectedSize === $s->name ? 'border-[#000080] text-[#000080] bg-[#000080]/5' : 'border-gray-200 text-gray-600 hover:border-[#000080] hover:text-[#000080]' }}">
                                        {{ $s->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="text-[13px] text-gray-500 mb-2 block font-semibold uppercase tracking-wider">Price Range (RM/day)</label>
                            <div class="flex items-center gap-2">
                                <input type="number" wire:model.lazy="priceMin" placeholder="Min" min="0" step="0.01"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-gray-50 text-[14px] outline-none" />
                                <span class="text-gray-400">-</span>
                                <input type="number" wire:model.lazy="priceMax" placeholder="Max" min="0" step="0.01"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-gray-50 text-[14px] outline-none" />
                            </div>
                        </div>

                        <div>
                            <label class="text-[13px] text-gray-500 mb-2 block font-semibold uppercase tracking-wider">Features</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 py-1.5 cursor-pointer">
                                    <input type="checkbox" wire:model="gps" class="rounded border-gray-300 text-[#000080] focus:ring-[#000080]" />
                                    <x-heroicon-s-map-pin class="w-4 h-4 text-gray-400" />
                                    <span class="text-[14px] text-gray-600">GPS Tracked</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#000080] text-white text-[14px] font-semibold hover:bg-[#000060] transition-colors">Apply</button>
                            <button type="button" wire:click="clearFilters" class="px-4 py-2.5 rounded-xl border border-gray-200 text-[14px] text-gray-600 hover:bg-gray-50 transition-colors">Clear</button>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- Results --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6 transition-all duration-600 ease-out"
                     :class="resultsInView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                     style="transition-delay: 0ms">
                    <div class="flex items-center gap-3">
                        <button x-show="!showFilters" @click="showFilters = true" type="button"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 hover:border-gray-300 text-[14px] text-gray-600 transition-colors">
                            <x-heroicon-s-funnel class="w-4 h-4" /> Filters
                        </button>
                        <span class="text-gray-500 text-[14px]">
                            <span class="text-[#1a1a2e] font-semibold">{{ $containers->total() }}</span> containers found
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            $sortOptions = ['relevance' => 'Relevance', 'price-low' => 'Price: Low to High', 'price-high' => 'Price: High to Low'];
                        @endphp
                        <details class="dropdown dropdown-end" x-data x-on:click.outside="$el.removeAttribute('open')">
                            <summary class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 cursor-pointer list-none text-[13px] text-gray-600 [&::-webkit-details-marker]:hidden">
                                <x-heroicon-s-arrow-path class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" />
                                <span>{{ $sortOptions[$sortBy] ?? 'Relevance' }}</span>
                                <x-heroicon-s-chevron-down class="w-3 h-3 text-gray-400 flex-shrink-0" />
                            </summary>
                            <ul class="dropdown-content menu bg-base-100 rounded-box z-50 min-w-48 p-2 shadow-lg border border-gray-100 mt-2">
                                @foreach($sortOptions as $value => $label)
                                    <li><a @click="$wire.set('sortBy', '{{ $value }}'); $el.closest('details').removeAttribute('open')" class="{{ $sortBy === $value ? 'bg-[#000080]/5 text-[#000080] font-semibold' : '' }}">{{ $label }}</a></li>
                                @endforeach
                            </ul>
                        </details>
                        <div class="flex rounded-lg border border-gray-200 overflow-hidden">
                            <button type="button" wire:click="setViewMode('grid')"
                                class="p-2 transition-colors {{ $viewMode === 'grid' ? 'bg-[#000080] text-white' : 'text-gray-400 hover:bg-gray-50' }}">
                                <x-heroicon-s-squares-plus class="w-4 h-4" />
                            </button>
                            <button type="button" wire:click="setViewMode('list')"
                                class="p-2 transition-colors {{ $viewMode === 'list' ? 'bg-[#000080] text-white' : 'text-gray-400 hover:bg-gray-50' }}">
                                <x-heroicon-s-bars-4 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
                

                <div class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5' : 'space-y-4' }}">
                    @forelse($containers as $container)
                        @php
                            try {
                                $structure = $container->getContainerStructureName();
                                $typeName = $structure['type'] ?? $container->title;
                                $sizeName = $structure['size'] ?? '';
                            } catch (\Throwable $e) {
                                $typeName = $container->title;
                                $sizeName = '';
                            }
                            $hasGps = $container->latitude && $container->longitude;
                        @endphp
                        <a href="{{ url('/containers/'.$container->id) }}{{ ($leaseStart && $leaseEnd) ? '?start='.$leaseStart.'&end='.$leaseEnd : '' }}"
                            class="group block bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-600 ease-out {{ $viewMode === 'list' ? 'flex' : '' }}"
                            :class="resultsInView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                            style="transition-delay: {{ 80 + $loop->index * 50 }}ms">
                            <div class="relative overflow-hidden transition-all duration-300 {{ $viewMode === 'list' ? 'w-72 flex-shrink-0 h-48' : 'h-48' }}">
                                @if($container->images && count($container->images) > 0)
                               
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($container->images[0]) }}" alt="{{ $container->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <x-heroicon-s-cube class="w-16 h-16 text-gray-300" />
                                    </div>
                                @endif

                                
                                
                                <div class="absolute top-3 left-3 px-2.5 py-1 bg-green-500 text-white rounded-full text-[11px] font-semibold">
                                    Available
                                </div>
                            </div>
                            <div class="p-5 flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-1">
                                    <div class="min-w-0">
                                        <h3 class="text-[#1a1a2e] text-[16px] font-semibold line-clamp-2" title="{{ $container->title }}">{{ $container->title }}</h3>
                                        {{-- <p class="text-gray-400 text-[13px] truncate">{{ $container->owner?->business_name ?? 'Owner' }}</p> --}}
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 mt-2 mb-3 text-gray-500 min-w-0">
                                    <x-heroicon-s-map-pin class="w-3.5 h-3.5 flex-shrink-0" />
                                    <span class="text-[13px] truncate">{{ $container->location ?? $container->full_address ?? '—' }}</span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 mb-4">
                                    @if($sizeName)
                                        <span class="px-2 py-0.5 bg-[#000080]/5 text-[#000080] rounded text-[12px] font-medium">{{ $sizeName }}</span>
                                    @endif
                                    @if($hasGps)
                                        <span class="flex items-center gap-1 text-[12px] text-gray-500">
                                            <x-heroicon-s-map-pin class="w-3 h-3" /> GPS
                                        </span>
                                    @endif
                                </div>
                                @php
                                    $dailyPrice = (float) ($container->daily_markup ?: $container->daily_rate);
                                    $monthlyPrice = (float) ($container->monthly_markup ?: $container->monthly_rate);
                                    $isGuest = auth()->guest();
                                @endphp
                                <div class="flex items-end justify-between border-t border-gray-50 pt-3">
                                    @if($isGuest)
                                        <div onclick="event.preventDefault(); event.stopPropagation(); window.location='{{ route('login') }}'"
                                             class="block cursor-pointer group grow" role="button" tabindex="0"
                                             title="Sign in to view price">
                                            <div class="blur-[4px] select-none group-hover:blur-[3px] transition-all">
                                                <span class="text-[#000080] text-[18px] font-bold">RM ---</span>
                                                <span class="text-gray-400 text-[13px]"> /day</span>
                                                <p class="text-gray-400 text-[12px]">RM --- /month</p>
                                            </div>
                                            <p class="text-[11px] text-amber-600 font-medium mt-1">Sign in to view price</p>
                                        </div>
                                    @else
                                        <div>
                                            <span class="text-[#000080] text-[18px] font-bold">RM {{ number_format($dailyPrice, 0) }}</span>
                                            <span class="text-gray-400 text-[13px]"> /day</span>
                                            <p class="text-gray-400 text-[12px]">RM {{ number_format($monthlyPrice, 0) }} /month</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-16 border border-dashed border-gray-200 rounded-2xl transition-all duration-600 ease-out"
                             :class="resultsInView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                             style="transition-delay: 80ms">
                            <x-heroicon-s-archive-box class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                            <p class="text-gray-500 text-[15px]">No containers match your search. Try adjusting your filters.</p>
                        </div>
                    @endforelse
                </div>

                @if($containers->hasPages())
                    <div class="mt-6 transition-all duration-600 ease-out"
                         :class="resultsInView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                         style="transition-delay: 200ms">{{ $containers->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
