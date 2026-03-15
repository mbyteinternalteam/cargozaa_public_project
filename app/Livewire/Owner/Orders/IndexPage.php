<?php

namespace App\Livewire\Owner\Orders;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Order;
use App\Models\Container;
use App\Models\Customer;
use App\Enums\OrderStatus;

#[Layout('owner.layout.app')]
#[Title('Orders - Cargozaa')]
class IndexPage extends Component
{
    use WithPagination;

    public string $searchQuery = '';
    public string $selectedFilter = 'all';
    public int $perPage = 10;

    public array $orderStats = [
        'totalOrders' => 0,
        'activeOrders' => 0,
        'completedOrders' => 0,
        'cancelledOrders' => 0,
    ];

    public function mount()
    {
        $this->loadOrderStats();
    }

    public function loadOrderStats()
    {
        $this->orderStats = [
            'totalOrders' => Order::count(),
            'activeOrders' => Order::where('status', OrderStatus::Active)->count(),
            'completedOrders' => Order::where('status', OrderStatus::Completed)->count(),
            'cancelledOrders' => Order::where('status', OrderStatus::Cancelled)->count(),
        ];
    }

    public function getOrdersProperty()
    {
        return Order::query()
            ->with(['customer', 'container'])
            ->when($this->selectedFilter !== 'all', function ($query) {
                $status = match($this->selectedFilter) {
                    'active' => OrderStatus::Active,
                    'pending' => OrderStatus::Pending,
                    'completed' => OrderStatus::Completed,
                    'cancelled' => OrderStatus::Cancelled,
                    default => null,
                };
                if ($status) {
                    $query->where('status', $status);
                }
            })
            ->when($this->searchQuery, function ($query) {
                $query->where(function ($q) {
                    $q->where('order_number', 'like', '%' . $this->searchQuery . '%')
                      ->orWhere('transaction_id', 'like', '%' . $this->searchQuery . '%')
                      ->orWhereHas('customer', function ($customerQuery) {
                          $customerQuery->where('company_name', 'like', '%' . $this->searchQuery . '%');
                      })
                      ->orWhereHas('container', function ($containerQuery) {
                          $containerQuery->where('type', 'like', '%' . $this->searchQuery . '%')
                                        ->orWhere('code', 'like', '%' . $this->searchQuery . '%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function getStatusBadgeClass(string $status): array
    {
        $configs = [
            'active' => [
                'bg' => 'bg-green-50',
                'text' => 'text-green-700',
                'border' => 'border-green-200',
                'icon' => 'check-circle',
            ],
            'pending' => [
                'bg' => 'bg-amber-50',
                'text' => 'text-amber-700',
                'border' => 'border-amber-200',
                'icon' => 'clock',
            ],
            'completed' => [
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-700',
                'border' => 'border-blue-200',
                'icon' => 'check-circle',
            ],
            'cancelled' => [
                'bg' => 'bg-red-50',
                'text' => 'text-red-700',
                'border' => 'border-red-200',
                'icon' => 'x-circle',
            ],
        ];

        return $configs[$status] ?? $configs['pending'];
    }

    public function viewOrder(string $orderId)
    {
        // Navigate to order details page
        return redirect()->route('owner.orders.show', $orderId);
    }

    public function render()
    {
        return view('livewire.owner.orders.index-page', [
            'orders' => $this->orders,
        ]);
    }
}
