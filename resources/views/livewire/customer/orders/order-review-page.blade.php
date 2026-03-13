@php
    $images = $container->images ?? [];
    $ownerName = $container->owner?->business_name ?? 'Owner';
@endphp

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-[13px] text-gray-400 mb-6">
            <a href="{{ route('customer.search') }}" class="hover:text-[#000080]">Containers</a>
            <x-heroicon-s-chevron-right class="w-3 h-3" />
            <a href="{{ route('customer.containers.show', $container) }}" class="hover:text-[#000080]">{{ $type ? "$size $type" : $container->title }}</a>
            <x-heroicon-s-chevron-right class="w-3 h-3" />
            <span class="text-[#1a1a2e]">Review Order</span>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-8">Review Your Order</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left: Forms --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Container Summary --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Container Details</h2>
                    <div class="flex gap-4">
                        <div class="w-24 h-24 rounded-xl overflow-hidden shrink-0 bg-gray-100">
                            @if(count($images) > 0)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($images[0]) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <x-heroicon-s-cube class="w-10 h-10 text-gray-300" />
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-[15px] font-semibold text-gray-900">{{ $container->title }}</h3>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $ownerName }}</p>
                            <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-600">
                                <span class="flex items-center gap-1"><x-heroicon-o-map-pin class="w-4 h-4" /> {{ $container->location ?? Str::limit($container->full_address, 40) }}</span>
                                <span class="flex items-center gap-1"><x-heroicon-o-calendar class="w-4 h-4" /> {{ \Carbon\Carbon::parse($leaseStart)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($leaseEnd)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <span class="px-2 py-0.5 bg-blue-50 text-[#000080] rounded text-xs font-medium">{{ $leaseDays }} days</span>
                                @if($insurance)
                                    <span class="px-2 py-0.5 bg-green-50 text-green-700 rounded text-xs font-medium">{{ $insurance->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Billing Address --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Billing Address</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">Street Address</label>
                            <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $billingAddress ?: '—' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">City</label>
                            <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $billingCity ?: '—' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">State</label>
                            <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $billingState ?: '—' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">Postal Code</label>
                            <p class="px-4 py-2.5 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-100">{{ $billingPostcode ?: '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Shipping Address</h2>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model.live="sameAsBilling" class="checkbox checkbox-sm checkbox-primary">
                            <span class="text-sm text-gray-600">Same as billing</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">Street Address</label>
                            <input wire:model="shippingAddress" type="text" @disabled($sameAsBilling)
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all {{ $sameAsBilling ? 'bg-gray-50 text-gray-500' : '' }}">
                            @error('shippingAddress')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">City</label>
                            <input wire:model="shippingCity" type="text" @disabled($sameAsBilling)
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all {{ $sameAsBilling ? 'bg-gray-50 text-gray-500' : '' }}">
                            @error('shippingCity')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">State</label>
                            <input wire:model="shippingState" type="text" @disabled($sameAsBilling)
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all {{ $sameAsBilling ? 'bg-gray-50 text-gray-500' : '' }}">
                            @error('shippingState')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">Postal Code</label>
                            <input wire:model="shippingPostcode" type="text" @disabled($sameAsBilling)
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all {{ $sameAsBilling ? 'bg-gray-50 text-gray-500' : '' }}">
                            @error('shippingPostcode')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Add-on Services --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Add-on Services</h2>
                    <label class="flex items-start gap-3 cursor-pointer p-4 rounded-xl border border-gray-200 hover:border-[#000080]/30 transition-colors">
                        <input type="checkbox" wire:model.live="hasAddon" class="checkbox checkbox-sm checkbox-primary mt-0.5">
                        <div>
                            <span class="text-sm font-semibold text-gray-900">I need additional services</span>
                            <p class="text-xs text-gray-500 mt-0.5">E.g. special handling, forklift, delivery assistance, etc.</p>
                        </div>
                    </label>
                    @if($hasAddon)
                        <div class="mt-4">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">Describe your add-on requirements</label>
                            <textarea wire:model="addOnRemark" rows="3" placeholder="Please describe what additional services you need..."
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#000080]/20 focus:border-[#000080] outline-none transition-all resize-none"></textarea>
                            @error('addOnRemark')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right: Order Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-[90px]">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-5">Order Summary</h2>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Container lease ({{ $leaseDays }} days)</span>
                                <span class="text-gray-900 font-medium">RM {{ number_format($leaseTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Insurance ({{ $insurance?->name ?? 'None' }})</span>
                                <span class="text-gray-900 font-medium">RM {{ number_format($insuranceTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Service fee (5%)</span>
                                <span class="text-gray-900 font-medium">RM {{ number_format($serviceFee, 2) }}</span>
                            </div>
                            <hr class="border-gray-100">
                            <div class="flex justify-between text-base">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="font-bold text-[#000080]">RM {{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>

                        <button type="button" wire:click="proceedToPayment"
                            class="w-full mt-6 flex items-center justify-center gap-2 py-3.5 rounded-xl bg-[#000080] text-white hover:bg-[#000060] transition-all text-[15px] font-semibold">
                            <span wire:loading.remove wire:target="proceedToPayment">
                                <x-heroicon-s-credit-card class="w-5 h-5 inline -mt-0.5" />
                                Select Payment
                            </span>
                            <span wire:loading wire:target="proceedToPayment">Processing...</span>
                        </button>

                        <p class="text-center text-gray-400 text-xs mt-3">Your payment is secure and encrypted</p>

                        <div class="mt-5 pt-4 border-t border-gray-100 space-y-2.5">
                            <div class="flex items-center gap-2.5 text-xs text-gray-500">
                                <x-heroicon-s-shield-check class="w-4 h-4 text-green-500 shrink-0" />
                                Secure payment processing
                            </div>
                            <div class="flex items-center gap-2.5 text-xs text-gray-500">
                                <x-heroicon-s-lock-closed class="w-4 h-4 text-green-500 shrink-0" />
                                256-bit SSL encryption
                            </div>
                            <div class="flex items-center gap-2.5 text-xs text-gray-500">
                                <x-heroicon-s-arrow-path class="w-4 h-4 text-green-500 shrink-0" />
                                Free cancellation within 24hrs
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
