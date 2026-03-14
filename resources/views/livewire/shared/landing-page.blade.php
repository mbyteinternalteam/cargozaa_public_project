<div class="flex flex-col">
    {{-- Hero --}}
    <section class="relative pt-12 pb-24 overflow-hidden bg-white">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-[#FFD700]/10 rounded-full blur-3xl opacity-50"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex flex-col items-center text-center mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#000080] text-sm font-semibold border border-blue-100 mb-6">
                    <x-heroicon-s-bolt class="w-4 h-4 text-[#FFD700]" />
                    #1 Container Leasing Platform
                </div>
                <h1 class="text-4xl lg:text-6xl font-extrabold text-[#000080] leading-tight mb-4">
                    Lease Containers <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#000080] to-[#FFD700]">Easily & Securely</span>
                </h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                    The smart way to find, book, and track shipping containers worldwide. For logistics, storage, and specialized cargo.
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="w-full max-w-6xl mx-auto mb-16">
                <a href="{{ route('customer.search') }}"
                    class="block bg-white p-2 rounded-3xl shadow-[0_32px_64px_-16px_rgba(0,0,128,0.15)] border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-0 rounded-2xl overflow-hidden">
                        <div class="p-5 md:border-r border-gray-100 hover:bg-gray-50 transition-colors flex items-center gap-4">
                            <x-heroicon-s-archive-box class="w-6 h-6 text-[#FFD700] shrink-0" />
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Goods Type</label>
                                <span class="text-base font-bold text-[#000080]">e.g. Refrigerated</span>
                            </div>
                        </div>
                        <div class="p-5 md:border-r border-gray-100 hover:bg-gray-50 transition-colors flex items-center gap-4">
                            <x-heroicon-s-map-pin class="w-6 h-6 text-[#FFD700] shrink-0" />
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Location</label>
                                <span class="text-base font-bold text-[#000080]">Port, City or Yard</span>
                            </div>
                        </div>
                        <div class="p-5 md:border-r border-gray-100 hover:bg-gray-50 transition-colors flex items-center gap-4">
                            <x-heroicon-s-calendar class="w-6 h-6 text-[#FFD700] shrink-0" />
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Lease Period</label>
                                <span class="text-base font-bold text-[#000080]">Start Date - End Date</span>
                            </div>
                        </div>
                        <div class="p-5 bg-[#000080] flex items-center justify-center group">
                            <x-heroicon-s-magnifying-glass class="w-6 h-6 text-white group-hover:scale-110 transition-transform" />
                            <span class="text-xl font-black text-white ml-3">Search Containers</span>
                        </div>
                    </div>
                </a>
                <div class="flex flex-wrap items-center justify-center gap-8 mt-6">
                    <div class="flex items-center gap-3 text-gray-400">
                        <x-heroicon-s-check-circle class="w-4 h-4 text-green-500" />
                        <span class="text-xs font-bold uppercase tracking-wider">No Credit Card Required</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-400">
                        <x-heroicon-s-check-circle class="w-4 h-4 text-green-500" />
                        <span class="text-xs font-bold uppercase tracking-wider">Free Cancellation</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-400">
                        <x-heroicon-s-check-circle class="w-4 h-4 text-green-500" />
                        <span class="text-xs font-bold uppercase tracking-wider">Verified Global Fleet</span>
                    </div>
                </div>
            </div>

            {{-- Transforming Logistics --}}
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl font-black text-[#000080]">Transforming Container Logistics</h2>
                    <p class="text-lg text-gray-500 leading-relaxed">
                        We've built a sophisticated container leasing platform. Whether you need a single 20ft dry unit or a fleet of reefers, Cargozaa delivers in minutes, not days.
                    </p>
                    <div class="flex items-center gap-6 pt-4">
                        <div class="flex -space-x-3">
                            @foreach ([1, 2, 3, 4] as $i)
                                <div class="w-12 h-12 rounded-full border-4 border-white bg-gray-200 overflow-hidden shadow-sm"></div>
                            @endforeach
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#000080]">2,500+ Active Companies</p>
                            <p class="text-xs text-gray-400 font-medium">Join the network today</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1605745341112-85968b19335b?auto=format&fit=crop&q=80&w=1200"
                            alt="Container port" class="w-full h-80 object-cover rounded-3xl">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#000080]/60 to-transparent rounded-3xl"></div>
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl border border-gray-100 max-w-xs animate-pulse">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <x-heroicon-s-shield-check class="text-green-600 w-6 h-6" />
                            </div>
                            <div>
                                <p class="text-sm font-bold text-[#000080]">Fully Insured</p>
                                <p class="text-xs text-gray-500">Coverage up to RM 500k</p>
                            </div>
                        </div>
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 w-[95%] rounded-full"></div>
                        </div>
                    </div>
                    <div class="absolute top-6 -right-6 bg-white p-4 rounded-2xl shadow-xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-widest">Live Tracking</p>
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            <x-heroicon-s-signal class="text-[#000080] w-4 h-4" />
                            <span class="text-sm font-medium">MSC Aurora • In Transit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-[#000080] mb-2">Why Lease with Cargozaa?</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">We simplify complex logistics with a digital-first approach to container leasing.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ([
                    ['icon' => 'signal', 'title' => 'Real-time GPS Tracking', 'desc' => 'Every container is equipped with IoT sensors for live location and condition monitoring.'],
                    ['icon' => 'shield-check', 'title' => 'Premium Insurance', 'desc' => 'Automatic theft, damage, and transit insurance included in every lease agreement.'],
                    ['icon' => 'calendar', 'title' => 'Flexible Leasing', 'desc' => 'From 24-hour emergency storage to multi-year contracts, we adapt to your needs.'],
                    ['icon' => 'check-badge', 'title' => 'Verified Owners', 'desc' => 'All listed containers are from KYC-verified owners you can trust.'],
                    ['icon' => 'sparkles', 'title' => 'Smart Pricing', 'desc' => 'Transparent daily, weekly, and monthly rates with no hidden fees.'],
                    ['icon' => 'phone', 'title' => 'Dedicated Support', 'desc' => '24/7 customer support for booking, tracking, and claims.'],
                ] as $benefit)
                    <div class="bg-white p-8 rounded-2xl border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all">
                        @php $icon = $benefit['icon']; @endphp
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                            <x-dynamic-component :component="'heroicon-s-'.$icon" class="w-8 h-8 text-[#000080]" />
                        </div>
                        <h3 class="text-xl font-bold text-[#000080] mb-4">{{ $benefit['title'] }}</h3>
                        <p class="text-gray-500 leading-relaxed">{{ $benefit['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Containers --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
                <div>
                    <h2 class="text-3xl font-black text-[#000080] mb-2">Available Containers Near You</h2>
                    <p class="text-gray-500">Ready for immediate dispatch from local ports.</p>
                </div>
                <a href="{{ route('customer.search') }}"
                    class="flex items-center gap-2 text-[#000080] font-bold hover:text-[#FFD700] transition-colors">
                    View all listings <x-heroicon-s-arrow-right class="w-4 h-4" />
                </a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredContainers as $container)
                    @php
                        try {
                            $struct = $container->getContainerStructureName();
                            $typeName = $struct['type'] ?? $container->title;
                            $sizeName = $struct['size'] ?? '';
                        } catch (\Throwable) {
                            $typeName = $container->title;
                            $sizeName = '';
                        }
                        $dailyPrice = (float) ($container->daily_markup ?: $container->daily_rate);
                        $isGuest = auth()->guest();
                    @endphp
                    <div class="group block bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all">
                        <a href="{{ route('customer.containers.show', $container) }}" class="block">
                            <div class="relative h-48 overflow-hidden">
                                @if($container->images && count($container->images) > 0)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($container->images[0]) }}"
                                        alt="{{ $typeName }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <x-heroicon-s-cube class="w-16 h-16 text-gray-300" />
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4">
                                    <span class="px-2.5 py-1 bg-green-500 text-white rounded-full text-[11px] font-semibold">Immediate</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $sizeName ?: '—' }}</span>
                                <h4 class="text-lg font-bold text-[#000080] mb-2 truncate mt-1">{{ $typeName }}</h4>
                                <div class="flex items-center gap-1.5 text-gray-400 text-sm mb-4">
                                    <x-heroicon-s-map-pin class="w-3.5 h-3.5" />
                                    {{ Str::limit($container->location ?? $container->full_address ?? '—', 25) }}
                                </div>
                            </div>
                        </a>
                        <div class="px-5 pb-5">
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                @if($isGuest)
                                    <a href="{{ route('login') }}" class="block cursor-pointer" title="Sign in to view price">
                                        <div class="blur-[4px] select-none">
                                            <span class="text-xl font-bold text-[#000080]">RM ---</span>
                                            <span class="text-gray-400 text-sm font-medium">/day</span>
                                        </div>
                                        <span class="block text-amber-600 text-[11px] font-medium mt-1">Sign in to view</span>
                                    </a>
                                @else
                                    <div>
                                        <span class="text-xl font-bold text-[#000080]">RM {{ number_format($dailyPrice, 0) }}</span>
                                        <span class="text-gray-400 text-sm font-medium">/day</span>
                                    </div>
                                @endif
                                <a href="{{ route('customer.containers.show', $container) }}" class="text-sm font-bold text-[#000080] hover:text-[#FFD700] transition-colors">Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <x-heroicon-s-cube class="w-16 h-16 mx-auto mb-4 text-gray-300" />
                        <p>No containers available. Check back soon.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Who Uses --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-[#000080] mb-2">Who Uses Cargozaa?</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">From logistics to warehousing, we serve businesses of all sizes.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['icon' => 'truck', 'title' => 'Logistics Companies', 'desc' => 'Ship and store cargo with flexible lease terms.'],
                    ['icon' => 'building-office-2', 'title' => 'Cold Chain Firms', 'desc' => 'Reefer containers for perishables and temperature-sensitive goods.'],
                    ['icon' => 'sparkles', 'title' => 'SMEs', 'desc' => 'Affordable storage and transit for growing businesses.'],
                    ['icon' => 'archive-box', 'title' => 'Warehouse Owners', 'desc' => 'Extend capacity with on-demand container storage.'],
                ] as $user)
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center">
                        <div class="w-12 h-12 bg-[#000080]/10 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-dynamic-component :component="'heroicon-s-'.$user['icon']" class="w-6 h-6 text-[#000080]" />
                        </div>
                        <h3 class="text-lg font-bold text-[#000080] mb-2">{{ $user['title'] }}</h3>
                        <p class="text-sm text-gray-500">{{ $user['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- AI Search Teaser --}}
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-[#000080] rounded-3xl p-12 lg:p-20 relative overflow-hidden">
                <div class="absolute bottom-0 right-0 w-1/2 h-full opacity-10 pointer-events-none flex items-center justify-end pr-10">
                    <x-heroicon-o-cube class="w-64 h-64 text-white" />
                </div>
                <div class="relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-white text-xs font-bold uppercase tracking-widest mb-6">
                        <x-heroicon-o-cube class="w-4 h-4 text-[#FFD700]" />
                        Powered by CargoAI
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-8">
                        Just tell us what you need. <br>We'll handle the rest.
                    </h2>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                        <p class="text-blue-100 italic text-lg mb-6">
                            "I need two 40ft refrigerated containers in Johor Port for about 3 months, starting next Tuesday. I need delivery to my warehouse."
                        </p>
                        <a href="{{ route('customer.search') }}"
                            class="inline-flex items-center gap-3 text-white font-bold hover:opacity-90 transition-opacity">
                            <div class="w-10 h-10 rounded-full bg-[#FFD700] flex items-center justify-center">
                                <x-heroicon-s-bolt class="w-6 h-6 text-[#000080]" />
                            </div>
                            Try AI Natural Search
                            <x-heroicon-s-arrow-right class="w-6 h-6" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
