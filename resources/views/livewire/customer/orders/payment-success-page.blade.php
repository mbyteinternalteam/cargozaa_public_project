@php
    $container = $order->container;
    $ownerName = $container?->owner?->business_name ?? 'Owner';
    $containerLabel = $container?->title ?? 'Container';
    $location = $container?->location ?? Str::limit($container?->full_address, 40) ?? '—';
@endphp

<div class="bg-gradient-to-b from-green-50/50 to-white min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-12">
        {{-- Success Icon --}}
        <div class="text-center mb-8">
            <div class="relative inline-block">
                <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mx-auto">
                    <x-heroicon-s-check-circle class="w-14 h-14 text-green-500" />
                </div>
                <div class="absolute -top-1 -right-1 w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center">
                    <x-heroicon-s-sparkles class="w-4 h-4 text-white" />
                </div>
            </div>
            <h1 class="text-[28px] font-bold text-gray-900 mt-5">Payment Successful!</h1>
            <p class="text-gray-500 text-[15px] mt-2 max-w-md mx-auto">Your payment has been processed successfully. Your container booking is confirmed and ready for use.</p>
        </div>

        {{-- Order Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm mb-6">
            {{-- Green Header --}}
            <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-green-200 text-xs font-semibold uppercase tracking-wider">Order ID</p>
                    <p class="text-white text-xl font-bold">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-green-200 text-xs font-semibold uppercase tracking-wider">Transaction ID</p>
                    <p class="text-white text-sm font-semibold">{{ $order->transaction_id }}</p>
                </div>
            </div>

            {{-- Order Details --}}
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                            <x-heroicon-s-cube class="w-5 h-5 text-[#000080]" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Container</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $containerLabel }}</p>
                            <p class="text-xs text-gray-500">{{ $ownerName }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                            <x-heroicon-s-map-pin class="w-5 h-5 text-green-600" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Location</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $location }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                            <x-heroicon-s-calendar class="w-5 h-5 text-purple-600" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Lease Period</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->lease_start->format('M d, Y') }} - {{ $order->lease_end->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $order->lease_days }} days</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-gray-50 flex items-center justify-center shrink-0">
                            <x-heroicon-s-credit-card class="w-5 h-5 text-gray-600" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Payment Method</p>
                            <p class="text-sm font-semibold text-gray-900">Credit Card</p>
                            <p class="text-xs text-gray-500">{{ $order->paid_at?->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100 mb-5">

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Amount Paid</p>
                        <p class="text-[28px] font-bold text-green-600">RM {{ number_format($order->total_amount, 0) }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-green-200 bg-green-50">
                        <x-heroicon-s-check class="w-4 h-4 text-green-600" />
                        <span class="text-green-700 text-sm font-semibold">Payment Confirmed</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="grid grid-cols-3 gap-3 mb-6">
            <button type="button" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <x-heroicon-o-arrow-down-tray class="w-4 h-4" /> Download Receipt
            </button>
            <button type="button" onclick="window.print()" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <x-heroicon-o-printer class="w-4 h-4" /> Print Receipt
            </button>
            <button type="button" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <x-heroicon-o-envelope class="w-4 h-4" /> Email Receipt
            </button>
        </div>

        {{-- What Happens Next --}}
        <div class="bg-green-50 rounded-2xl border border-green-100 p-6 mb-6">
            <h2 class="flex items-center gap-2 text-lg font-bold text-gray-900 mb-4">
                <x-heroicon-o-bell-alert class="w-5 h-5 text-green-600" />
                What Happens Next?
            </h2>
            <div class="space-y-4">
                @foreach([
                    ['num' => '1', 'title' => 'Confirmation Email Sent', 'desc' => 'Check your inbox for booking confirmation and contract details'],
                    ['num' => '2', 'title' => 'Container Preparation', 'desc' => 'The owner will prepare your container and confirm pickup details'],
                    ['num' => '3', 'title' => 'Track Your Container', 'desc' => 'Use GPS tracking to monitor your container location in real-time'],
                ] as $step)
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold shrink-0">{{ $step['num'] }}</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $step['title'] }}</p>
                            <p class="text-xs text-gray-500">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Navigation Buttons --}}
        <div class="grid grid-cols-3 gap-3 mb-6">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center justify-center gap-2 py-3.5 rounded-xl bg-[#000080] text-white text-sm font-semibold hover:bg-[#000060] transition-colors">
                <x-heroicon-s-clipboard-document-list class="w-4 h-4" /> View My Orders
            </a>
            <a href="#" class="flex items-center justify-center gap-2 py-3.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                <x-heroicon-s-signal class="w-4 h-4" /> Track Container
            </a>
            <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 py-3.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                <x-heroicon-s-home class="w-4 h-4" /> Back to Home
            </a>
        </div>

        {{-- Auto-redirect notice --}}
        <p class="text-center text-sm text-gray-400" x-data="{ seconds: {{ $countdown }} }"
           x-init="let t = setInterval(() => { seconds--; if (seconds <= 0) { clearInterval(t); window.location.href = '{{ route('customer.dashboard') }}'; } }, 1000)">
            You will be redirected to your orders page in <span class="font-bold text-gray-600" x-text="seconds"></span> seconds
        </p>
    </div>
</div>
