<?php

namespace App\Livewire\Customer\orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('shared.layouts.app')]
class PaymentFailedPage extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        if (! Auth::check() || $order->customer_id !== Auth::user()->customer?->id) {
            abort(403);
        }

        $this->order = $order->load(['container.owner', 'insurance']);
    }

    public function retryPayment(): void
    {
        $this->order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'paid_at' => now(),
            'payment_error' => null,
        ]);

        $this->redirectRoute('customer.orders.payment-success', $this->order);
    }

    public function render(): View
    {
        return view('livewire.customer.orders.payment-failed-page');
    }
}
