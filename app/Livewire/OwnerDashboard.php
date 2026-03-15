<?php

namespace App\Livewire;

use App\Service\ContainerService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('owner.layout.app')]
#[Title('Dashboard - Cargozaa')]
class OwnerDashboard extends Component
{
    public $selectedPeriod = 'last_6_months';
    
    protected ContainerService $containerService;
    
    public array $periods = [
        'last_7_days' => 'Last 7 Days',
        'last_30_days' => 'Last 30 Days',
        'last_3_months' => 'Last 3 Months',
        'last_6_months' => 'Last 6 Months',
        'last_year' => 'Last Year',
    ];

    public function boot(ContainerService $containerService): void
    {
        $this->containerService = $containerService;
    }

    public function mount()
    {
        $this->selectedPeriod = 'last_6_months';
    }

    public function updatedSelectedPeriod($value)
    {
        // Handle period change - could trigger data refresh
        $this->selectedPeriod = $value;
    }


    public function getStatsProperty()
    {
        $ownerId = Auth::user()?->owner?->id;
        if (!$ownerId) {
            return [];
        }

        $currentActiveCount = $this->containerService->getCurrentMonthActiveContainersCount($ownerId);
        $previousActiveCount = $this->containerService->getPreviousMonthActiveContainersCount($ownerId);
        
        // Calculate change
        $change = $currentActiveCount - $previousActiveCount;
        $changeType = $change > 0 ? 'positive' : ($change < 0 ? 'negative' : 'neutral');
        $changeText = $change > 0 ? "+{$change}" : ($change < 0 ? (string)$change : '0');
        $trend = $change > 0 ? 'up' : ($change < 0 ? 'down' : 'neutral');
        
        return [
            'totalRevenue' => [
                'title' => 'Total Revenue',
                'value' => 'RM 109,500',
                'change' => '+12.5%',
                'changeType' => 'positive',
                'comparison' => 'vs last period',
                'icon' => 'trending-up',
                'color' => '#000080',
                'bgColor' => '#E6E6FA',
                'trend' => 'up'
            ],
            'activeContainers' => [
                'title' => 'Active Containers',
                'value' => $currentActiveCount,
                'change' => $changeText,
                'changeType' => $changeType,
                'comparison' => 'vs last month',
                'icon' => 'package',
                'color' => '#FFD700',
                'bgColor' => '#FFF9E6',
                'trend' => $trend
            ],
            'totalBookings' => [
                'title' => 'Total Bookings',
                'value' => '128',
                'change' => '+8.2%',
                'changeType' => 'positive',
                'comparison' => 'vs last month',
                'icon' => 'calendar',
                'color' => '#4169E1',
                'bgColor' => '#E6F0FF',
                'trend' => 'up'
            ],
            'occupancyRate' => [
                'title' => 'Occupancy Rate',
                'value' => '78%',
                'change' => '-2.1%',
                'changeType' => 'negative',
                'comparison' => 'vs last month',
                'icon' => 'trending-up',
                'color' => '#FFA500',
                'bgColor' => '#FFF0E0',
                'trend' => 'down'
            ]
        ];
    }

    public function getRecentBookingsProperty()
    {
        return [
            [
                'id' => 'BK-1234',
                'customer' => 'ABC Logistics Sdn Bhd',
                'container' => 'CNT-002',
                'startDate' => '2026-02-15',
                'duration' => '30 days',
                'amount' => 'RM 8,400',
                'status' => 'Active'
            ],
            [
                'id' => 'BK-1235',
                'customer' => 'XYZ Construction',
                'container' => 'CNT-001',
                'startDate' => '2026-02-18',
                'duration' => '15 days',
                'amount' => 'RM 2,250',
                'status' => 'Active'
            ],
            [
                'id' => 'BK-1236',
                'customer' => 'Global Shipping Co',
                'container' => 'CNT-003',
                'startDate' => '2026-02-20',
                'duration' => '45 days',
                'amount' => 'RM 9,900',
                'status' => 'Pending'
            ],
            [
                'id' => 'BK-1237',
                'customer' => 'Mega Warehouse Sdn Bhd',
                'container' => 'CNT-005',
                'startDate' => '2026-02-10',
                'duration' => '60 days',
                'amount' => 'RM 8,700',
                'status' => 'Active'
            ]
        ];
    }

    public function getContainerStatusProperty()
    {
        return [
            'available' => 3,
            'occupied' => 18,
            'maintenance' => 2,
            'reserved' => 1
        ];
    }

    public function getRevenueDataProperty()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'revenue' => [12500, 15800, 18200, 16900, 21500, 24800],
            'bookings' => [15, 18, 22, 20, 25, 28]
        ];
    }

    public function getContainerTypeDataProperty()
    {
        return [
            ['name' => '20ft Standard', 'value' => 35, 'color' => '#000080'],
            ['name' => '40ft Standard', 'value' => 28, 'color' => '#FFD700'],
            ['name' => '40ft High Cube', 'value' => 22, 'color' => '#4169E1'],
            ['name' => 'Refrigerated', 'value' => 15, 'color' => '#FFA500']
        ];
    }

    public function getContainerListingsProperty()
    {
        return [
            [
                'id' => 'CNT-001',
                'type' => '20ft Standard',
                'location' => 'Port Klang, Malaysia',
                'status' => 'Available',
                'rate' => 'RM 150/day',
                'bookings' => 12,
                'revenue' => 'RM 21,600'
            ],
            [
                'id' => 'CNT-002',
                'type' => '40ft High Cube',
                'location' => 'Penang Port, Malaysia',
                'status' => 'Rented',
                'rate' => 'RM 280/day',
                'bookings' => 8,
                'revenue' => 'RM 33,600'
            ],
            [
                'id' => 'CNT-003',
                'type' => '40ft Standard',
                'location' => 'Johor Port, Malaysia',
                'status' => 'Available',
                'rate' => 'RM 220/day',
                'bookings' => 15,
                'revenue' => 'RM 49,500'
            ],
            [
                'id' => 'CNT-004',
                'type' => 'Refrigerated 20ft',
                'location' => 'Port Klang, Malaysia',
                'status' => 'Maintenance',
                'rate' => 'RM 380/day',
                'bookings' => 6,
                'revenue' => 'RM 34,200'
            ],
            [
                'id' => 'CNT-005',
                'type' => '20ft Standard',
                'location' => 'Kuantan Port, Malaysia',
                'status' => 'Available',
                'rate' => 'RM 145/day',
                'bookings' => 10,
                'revenue' => 'RM 17,400'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.owner.dashboard');
    }
}
