<?php

namespace App\Livewire\Customer\orders;

use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('shared.layouts.app')]
class PaymentSuccessPage extends Component
{
    public Order $order;

    public int $countdown = 5;

    public function mount(Order $order): void
    {
        if (! Auth::check() || $order->customer_id !== Auth::user()->customer?->id) {
            abort(403);
        }

        if ($order->payment_status !== PaymentStatus::Paid) {
            $this->redirectRoute('customer.orders.payment-failed', $order);

            return;
        }

        $this->order = $order->load(['container.owner', 'insurance']);
    }

    public function render(): View
    {
        return view('livewire.customer.orders.payment-success-page');
    }
}
