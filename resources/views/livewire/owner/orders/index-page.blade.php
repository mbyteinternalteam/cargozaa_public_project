<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h1 class="text-[#1a1a2e]" style="font-size: 28px; font-weight: 700;">
                        Container Orders
                    </h1>
                    <p class="text-gray-500 text-[15px]">Track and manage all bookings for your containers</p>
                </div>
                <button class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors text-[14px]" style="font-weight: 600;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Orders
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="p-5 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#000080]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[#000080]" style="font-size: 24px; font-weight: 700;">{{ $orderStats['totalOrders'] }}</p>
                    </div>
                </div>
                <p class="text-gray-500 text-[13px]">Total Orders</p>
            </div>

            <div class="p-5 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-green-600" style="font-size: 24px; font-weight: 700;">{{ $orderStats['activeOrders'] }}</p>
                    </div>
                </div>
                <p class="text-gray-500 text-[13px]">Active Orders</p>
            </div>

            <div class="p-5 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-blue-600" style="font-size: 24px; font-weight: 700;">{{ $orderStats['completedOrders'] }}</p>
                    </div>
                </div>
                <p class="text-gray-500 text-[13px]">Completed</p>
            </div>

            <div class="p-5 rounded-2xl border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-red-600" style="font-size: 24px; font-weight: 700;">{{ $orderStats['cancelledOrders'] }}</p>
                    </div>
                </div>
                <p class="text-gray-500 text-[13px]">Cancelled</p>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="rounded-2xl border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1 relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input
                        type="text"
                        wire:model.live="searchQuery"
                        placeholder="Search by order ID, customer, or container..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080]"
                    />
                </div>

                <!-- Status Filter -->
                <div class="relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <select
                        wire:model.live="selectedFilter"
                        class="pl-10 pr-10 py-2.5 rounded-xl border border-gray-200 text-[14px] outline-none focus:border-[#000080] appearance-none bg-white cursor-pointer"
                        style="font-weight: 500"
                    >
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="rounded-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[12px] text-gray-500 uppercase tracking-wider" style="font-weight: 600;">
                                Order Details
                            </th>
                            <th class="px-6 py-4 text-left text-[12px] text-gray-500 uppercase tracking-wider" style="font-weight: 600;">
                                Customer
                            </th>
                            <th class="px-6 py-4 text-left text-[12px] text-gray-500 uppercase tracking-wider" style="font-weight: 600;">
                                Container & Location
                            </th>
                            <th class="px-6 py-4 text-left text-[12px] text-gray-500 uppercase tracking-wider" style="font-weight: 600;">
                                Rental Period
                            </th>
                            <th class="px-6 py-4 text-left text-[12px] text-gray-500 uppercase tracking-wider" style="font-weight: 600;">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-[12px] text-gray-500 uppercase tracking-wider" style="font-weight: 600;">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Order Details -->
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-[#000080] text-[14px] mb-1" style="font-weight: 600;">
                                            {{ $order->order_number }}
                                        </p>
                                        <p class="text-gray-400 text-[12px]">
                                            Transaction: {{ $order->transaction_id }}
                                        </p>
                                        <p class="text-gray-400 text-[11px] mt-0.5">
                                            Created: {{ $order->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </td>

                                <!-- Customer -->
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-2">
                                        <div class="w-8 h-8 rounded-full bg-[#000080]/10 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-[#000080]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-[#1a1a2e] text-[14px] mb-0.5" style="font-weight: 600;">
                                                {{ $order->customer?->company_name ?? 'N/A' }}
                                            </p>
                                            <p class="text-gray-400 text-[12px]">
                                                {{ $order->customer?->user?->email ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Container & Location -->
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="flex items-center gap-1.5 text-[#1a1a2e] text-[14px] mb-1" style="font-weight: 500;">
                                            <svg class="w-3.5 h-3.5 text-[#000080]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            {{ $order->container?->type ?? 'N/A' }} - {{ $order->container?->code ?? 'N/A' }}
                                        </div>
                                        <div class="flex items-center gap-1.5 text-gray-400 text-[12px]">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $order->container?->location ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Rental Period -->
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="flex items-center gap-1.5 text-[#1a1a2e] text-[13px] mb-1" style="font-weight: 500;">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $order->lease_start->format('d M') }} - {{ $order->lease_end->format('d M Y') }}
                                        </div>
                                        <p class="text-gray-400 text-[12px] pl-5">
                                            {{ $order->lease_days }} days
                                        </p>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = $this->getStatusBadgeClass($order->status->value);
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}" style="font-weight: 600;">
                                        <x-heroicon-{{ $statusConfig['icon'] }} class="w-3.5 h-3.5" />
                                        {{ ucfirst($order->status->value) }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <button 
                                        wire:click="viewOrder('{{ $order->id }}')"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors text-[13px]" 
                                        style="font-weight: 500"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="text-gray-400 text-[14px]" style="font-weight: 500;">
                                        No orders found
                                    </p>
                                    <p class="text-gray-400 text-[12px] mt-1">
                                        Try adjusting your filters or search query
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="flex items-center justify-between mt-6">
                <p class="text-gray-500 text-[13px]">
                    Showing <span style="font-weight: 600;">{{ $orders->count() }}</span> of <span style="font-weight: 600;">{{ $orders->total() }}</span> orders
                </p>
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
