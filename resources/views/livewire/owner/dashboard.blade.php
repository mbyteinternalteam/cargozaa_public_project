<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 mt-16">
    <!-- Header -->
    <div class="">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-gray-600 mt-1">Welcome back! Here's your container portfolio overview</p>
                </div>
                <div class="flex items-center gap-3">
                    <select 
                        wire:model="selectedPeriod" 
                        class="px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white mt-4"
                    >
                        @foreach($periods as $value => $label)
                            <option value="{{ $value }}" {{ $selectedPeriod === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($this->stats as $index => $stat)
                @php
                    $animationDelay = (int)$index * 0.1;
                @endphp
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow" style="animation-delay: {{ $animationDelay }}s;">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-2">{{ $stat['title'] }}</p>
                            <h3 class="text-3xl font-bold mb-2" style="color: {{ $stat['color'] }};">
                                {{ $stat['value'] }}
                            </h3>
                            <div class="flex items-center gap-1">
                                @if($stat['trend'] === 'up')
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                    </svg>
                                @endif
                                <span class="text-sm font-semibold {{ $stat['trend'] === 'up' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $stat['change'] }}
                                </span>
                                <span class="text-xs text-gray-500">vs last period</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: {{ $stat['bgColor'] }};">
                            @switch($stat['icon'])
                                @case('trending-up')
                                    <svg class="w-6 h-6" style="color: {{ $stat['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    @break
                                @case('package')
                                    <svg class="w-6 h-6" style="color: {{ $stat['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    @break
                                @case('calendar')
                                    <svg class="w-6 h-6" style="color: {{ $stat['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    @break
                                @case('chart-bar')
                                    <svg class="w-6 h-6" style="color: {{ $stat['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-2xl p-4 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold" style="color: #000080;">Revenue Overview</h3>
                        <p class="text-xs text-gray-600">Monthly revenue and bookings</p>
                    </div>
                </div>
                <div class="h-40 w-4/5 relative mt-4 mx-auto">
                    @php
                        $maxRevenue = max($this->revenueData['revenue'] ?: [100]);
                        $maxBookings = max($this->revenueData['bookings'] ?: [10]);
                        $dataCount = count($this->revenueData['labels']);
                        $width = 100;
                        $height = 100;
                        $padding = 10;
                        
                        $pointsRevenue = [];
                        $pointsBookings = [];
                        
                        foreach($this->revenueData['revenue'] as $index => $value) {
                            $x = ($index / ($dataCount - 1)) * $width;
                            $y = $height - (($value / $maxRevenue) * ($height - $padding * 2) + $padding);
                            $pointsRevenue[] = "$x,$y";
                        }
                        
                        foreach($this->revenueData['bookings'] as $index => $value) {
                            $x = ($index / ($dataCount - 1)) * $width;
                            $y = $height - (($value / $maxBookings) * ($height - $padding * 2) + $padding);
                            $pointsBookings[] = "$x,$y";
                        }
                        
                        $pathRevenue = "M " . implode(" L ", $pointsRevenue);
                        $pathBookings = "M " . implode(" L ", $pointsBookings);
                    @endphp

                    <!-- Grid Lines -->
                    <div class="absolute inset-0">
                        <div class="h-full w-full relative">
                            <!-- Horizontal grid lines -->
                            <div class="absolute inset-0">
                                <div class="absolute w-full border-t border-gray-200" style="top: 0%;"></div>
                                <div class="absolute w-full border-t border-gray-200" style="top: 25%;"></div>
                                <div class="absolute w-full border-t border-gray-200" style="top: 50%;"></div>
                                <div class="absolute w-full border-t border-gray-200" style="top: 75%;"></div>
                                <div class="absolute w-full border-t border-gray-200" style="top: 100%;"></div>
                            </div>
                        </div>
                    </div>

                    <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full overflow-visible">
                        <!-- Revenue Path -->
                        <path d="{{ $pathRevenue }}" fill="none" stroke="#1e40af" stroke-width="2" vector-effect="non-scaling-stroke" />
                        
                        <!-- Bookings Path -->
                        <path d="{{ $pathBookings }}" fill="none" stroke="#eab308" stroke-width="2" vector-effect="non-scaling-stroke" />
                    </svg>

                    <!-- Revenue Points -->
                    @foreach($pointsRevenue as $point)
                        @php list($x, $y) = explode(',', $point); @endphp
                        <div class="absolute w-3 h-3 bg-blue-800 rounded-full border-2 border-white shadow-sm transform -translate-x-1/2 -translate-y-1/2 hover:scale-125 transition-transform cursor-pointer" 
                             style="left: {{ $x }}%; top: {{ $y }}%; z-index: 10;"></div>
                    @endforeach
                    
                    <!-- Bookings Points -->
                    @foreach($pointsBookings as $point)
                        @php list($x, $y) = explode(',', $point); @endphp
                        <div class="absolute w-3 h-3 bg-yellow-500 rounded-full border-2 border-white shadow-sm transform -translate-x-1/2 -translate-y-1/2 hover:scale-125 transition-transform cursor-pointer" 
                             style="left: {{ $x }}%; top: {{ $y }}%; z-index: 10;"></div>
                    @endforeach

                    <!-- X-Axis Labels -->
                    <div class="absolute -bottom-6 left-0 right-0 flex justify-between px-2">
                        @foreach($this->revenueData['labels'] as $label)
                            <span class="text-xs text-gray-500">{{ $label }}</span>
                        @endforeach
                    </div>

                    <!-- Y-Axis Labels -->
                    <div class="absolute -left-12 top-0 bottom-0 flex flex-col justify-between py-2">
                        <span class="text-xs text-gray-500">{{ $maxRevenue }}</span>
                        <span class="text-xs text-gray-500">{{ round($maxRevenue * 0.75) }}</span>
                        <span class="text-xs text-gray-500">{{ round($maxRevenue * 0.5) }}</span>
                        <span class="text-xs text-gray-500">{{ round($maxRevenue * 0.25) }}</span>
                        <span class="text-xs text-gray-500">0</span>
                    </div>

                    <!-- Legend -->
                    <div class="absolute -top-10 right-0 flex gap-4">
                        <div class="flex items-center gap-1">
                            <div class="w-6 h-0.5 bg-blue-800 rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-blue-800 rounded-full -ml-2"></div>
                            <span class="text-xs text-gray-600">Revenue (RM)</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="w-6 h-0.5 bg-yellow-500 rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full -ml-2"></div>
                            <span class="text-xs text-gray-600">Bookings</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container Distribution -->
            <div class="bg-white rounded-2xl p-4 shadow-lg">
                <div class="mb-4">
                    <h3 class="text-lg font-bold" style="color: #000080;">Container Distribution</h3>
                    <p class="text-xs text-gray-600">By container type</p>
                </div>
                <div class="flex items-center justify-between">
                    <!-- Pie Chart Representation -->
                    <div class="relative w-48 h-48">
                        <div class="absolute inset-0 rounded-full" style="background: conic-gradient(
                            #000080 0deg 126deg,
                            #FFD700 126deg 226.8deg,
                            #4169E1 226.8deg 306deg,
                            #FFA500 306deg 360deg
                        );"></div>
                        <div class="absolute inset-8 bg-white rounded-full flex items-center justify-center">
                            <span class="text-lg font-bold" style="color: #000080;"></span>
                        </div>
                    </div>
                    <div class="flex-1 space-y-4 ml-4">
                        @foreach($this->containerTypeData as $item)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $item['color'] }};"></div>
                                    <span class="text-sm text-gray-700">{{ $item['name'] }}</span>
                                </div>
                                <span class="text-sm font-semibold" style="color: #000080;">{{ $item['value'] }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold" style="color: #000080;">Recent Bookings</h3>
                        <p class="text-sm text-gray-600">Latest customer bookings</p>
                    </div>
                    <button class="px-4 py-2 text-sm font-semibold rounded-lg border-2 hover:bg-gray-50 transition-colors" style="border-color: #000080; color: #000080;">
                        View All
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Booking ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Container</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($this->recentBookings as $booking)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold" style="color: #000080;">{{ $booking['id'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700">{{ $booking['customer'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">{{ $booking['container'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ $booking['startDate'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700">{{ $booking['duration'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold" style="color: #FFD700;">{{ $booking['amount'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($booking['status'])
                                        @case('Active')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold border bg-green-100 text-green-700 border-green-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2h2a2 2 0 002-2V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                                                </svg>
                                                Active
                                            </span>
                                            @break
                                        @case('Pending')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold border bg-orange-100 text-orange-700 border-orange-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Pending
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
