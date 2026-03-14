<div class="bg-gradient-to-b from-red-50/50 to-white min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-12">
        {{-- Failed Icon --}}
        <div class="text-center mb-8">
            <div class="relative inline-block">
                <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mx-auto">
                    <x-heroicon-s-x-circle class="w-14 h-14 text-red-500" />
                </div>
                <div class="absolute -top-1 -right-1 w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center">
                    <x-heroicon-s-exclamation-triangle class="w-4 h-4 text-white" />
                </div>
            </div>
            <h1 class="text-[28px] font-bold text-gray-900 mt-5">Payment Declined</h1>
            <p class="text-gray-500 text-[15px] mt-2 max-w-md mx-auto">Your payment was declined by your bank or card issuer.<br>Don't worry, no charges have been made to your account.</p>
        </div>

        {{-- Order Header --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm mb-6">
            <div class="bg-gradient-to-r from-red-600 to-red-500 px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="text-red-200 text-xs font-semibold uppercase tracking-wider">Order ID</p>
                    <p class="text-white text-xl font-bold">{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-red-200 text-xs font-semibold uppercase tracking-wider">Amount</p>
                    <p class="text-white text-xl font-bold">RM {{ number_format($order->total_amount, 0) }}</p>
                </div>
            </div>

            <div class="p-6">
                {{-- Error Info --}}
                <div class="p-4 bg-red-50 rounded-xl border border-red-100 mb-6">
                    <div class="flex items-start gap-3">
                        <x-heroicon-s-information-circle class="w-5 h-5 text-red-500 shrink-0 mt-0.5" />
                        <div>
                            <p class="text-sm font-semibold text-red-800">Payment Failed</p>
                            <p class="text-sm text-red-600 mt-0.5">{{ $order->payment_error ?? 'Your payment was declined by your bank' }}</p>
                            <p class="text-xs text-red-500 mt-1 font-mono">Error Code: PAYMENT_DECLINED</p>
                        </div>
                    </div>
                </div>

                {{-- What You Can Do --}}
                <h3 class="flex items-center gap-2 text-base font-bold text-gray-900 mb-3">
                    <x-heroicon-o-question-mark-circle class="w-5 h-5 text-gray-400" />
                    What You Can Do
                </h3>
                <div class="space-y-3 mb-4">
                    @foreach([
                        'Check if you have sufficient funds in your account',
                        'Verify your card details are correct',
                        'Contact your bank to authorize this transaction',
                        'Try using a different payment method',
                    ] as $i => $tip)
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-blue-100 text-[#000080] flex items-center justify-center text-xs font-bold shrink-0">{{ $i + 1 }}</div>
                            <span class="text-sm text-gray-600">{{ $tip }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="grid grid-cols-2 gap-3 mb-6">
            <button type="button" wire:click="retryPayment"
                class="flex items-center justify-center gap-2 py-3.5 rounded-xl bg-[#000080] text-white text-sm font-semibold hover:bg-[#000060] transition-colors">
                <span wire:loading.remove wire:target="retryPayment">
                    <x-heroicon-s-arrow-path class="w-4 h-4 inline -mt-0.5" /> Try Again with Different Payment
                </span>
                <span wire:loading wire:target="retryPayment">Processing...</span>
            </button>
            <a href="{{ route('customer.search') }}"
               class="flex items-center justify-center gap-2 py-3.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                <x-heroicon-s-arrow-left class="w-4 h-4" /> Continue Shopping
            </a>
        </div>

        {{-- Need Help --}}
        <div class="bg-blue-50 rounded-2xl border border-blue-100 p-6 mb-6">
            <h2 class="flex items-center gap-2 text-lg font-bold text-gray-900 mb-3">
                <x-heroicon-o-phone class="w-5 h-5 text-[#000080]" />
                Need Help?
            </h2>
            <p class="text-sm text-gray-600 mb-4">Our customer support team is here to assist you 24/7. Choose your preferred contact method:</p>
            <div class="grid grid-cols-3 gap-3">
                <div class="text-center p-4 bg-white rounded-xl border border-blue-100">
                    <x-heroicon-o-phone class="w-6 h-6 text-[#000080] mx-auto mb-2" />
                    <p class="text-xs font-semibold text-gray-900">Call Us</p>
                    <p class="text-xs text-gray-500">+60 12-345 6789</p>
                </div>
                <div class="text-center p-4 bg-white rounded-xl border border-blue-100">
                    <x-heroicon-o-envelope class="w-6 h-6 text-[#000080] mx-auto mb-2" />
                    <p class="text-xs font-semibold text-gray-900">Email Us</p>
                    <p class="text-xs text-gray-500">support@cargozaa.com</p>
                </div>
                <div class="text-center p-4 bg-white rounded-xl border border-blue-100">
                    <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-[#000080] mx-auto mb-2" />
                    <p class="text-xs font-semibold text-gray-900">Live Chat</p>
                    <p class="text-xs text-gray-500">Available 24/7</p>
                </div>
            </div>
        </div>

        {{-- Bottom Nav --}}
        <div class="grid grid-cols-2 gap-3 mb-6">
            <a href="{{ route('customer.dashboard') }}" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <x-heroicon-o-clipboard-document-list class="w-4 h-4" /> View My Orders
            </a>
            <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <x-heroicon-o-home class="w-4 h-4" /> Back to Home
            </a>
        </div>

        {{-- Security Notice --}}
        <div class="text-center text-xs text-gray-400 bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
            <x-heroicon-o-shield-check class="w-4 h-4 inline -mt-0.5 mr-1" />
            <strong>Your Payment is Secure</strong><br>
            All transactions are encrypted and processed through secure payment gateways. Your financial information is never stored on our servers.
        </div>
    </div>
</div>
