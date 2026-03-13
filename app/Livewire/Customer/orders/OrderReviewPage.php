<?php

namespace App\Livewire\Customer\orders;

use App\Models\Container;
use App\Models\Insurance;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('shared.layouts.app')]
class OrderReviewPage extends Component
{
    public Container $container;

    public ?Insurance $insurance = null;

    public string $leaseStart = '';

    public string $leaseEnd = '';

    public int $leaseDays = 0;

    public string $type = '';

    public string $size = '';

    #[Validate('required|string|max:500')]
    public string $billingAddress = '';

    public string $billingCity = '';

    public string $billingState = '';

    public string $billingPostcode = '';

    public bool $sameAsBilling = true;

    #[Validate('required|string|max:500')]
    public string $shippingAddress = '';

    public string $shippingCity = '';

    public string $shippingState = '';

    public string $shippingPostcode = '';

    public bool $hasAddon = false;

    public string $addOnRemark = '';

    public function mount(Container $container): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login');

            return;
        }

        $this->container = $container->load('owner');
        $this->leaseStart = request()->query('start', '');
        $this->leaseEnd = request()->query('end', '');
        $this->leaseDays = ($this->leaseStart && $this->leaseEnd)
            ? max(1, Carbon::parse($this->leaseStart)->diffInDays(Carbon::parse($this->leaseEnd)))
            : 30;

        $insuranceId = request()->query('insurance');
        if ($insuranceId) {
            $this->insurance = Insurance::query()->find($insuranceId);
        }

        try {
            $structure = $container->getContainerStructureName();
            $this->type = $structure['type'] ?? '';
            $this->size = $structure['size'] ?? '';
        } catch (\Throwable) {
            //
        }

        $customer = Auth::user()->customer;
        if ($customer) {
            $this->billingAddress = $customer->billing_address ?? '';
            $this->billingCity = $customer->billing_city ?? '';
            $this->billingState = $customer->billingState?->name ?? '';
            $this->billingPostcode = $customer->billing_postcode ?? '';
        }

        $this->syncShippingFromBilling();
    }

    public function updatedSameAsBilling(): void
    {
        if ($this->sameAsBilling) {
            $this->syncShippingFromBilling();
        }
    }

    protected function syncShippingFromBilling(): void
    {
        if ($this->sameAsBilling) {
            $this->shippingAddress = $this->billingAddress;
            $this->shippingCity = $this->billingCity;
            $this->shippingState = $this->billingState;
            $this->shippingPostcode = $this->billingPostcode;
        }
    }

    public function proceedToPayment(): void
    {
        $this->validate([
            'shippingAddress' => 'required|string|max:500',
            'shippingCity' => 'required|string|max:100',
            'shippingState' => 'required|string|max:100',
            'shippingPostcode' => 'required|string|max:10',
        ]);

        if ($this->hasAddon && empty(trim($this->addOnRemark))) {
            $this->addError('addOnRemark', 'Please describe the add-on service you need.');

            return;
        }

        $user = Auth::user();
        $customer = $user->customer;
        $dailyRate = (float) ($this->container->daily_markup ?: $this->container->daily_rate);
        $insuranceRate = (float) ($this->insurance?->daily_rate ?? 0);
        $leaseTotal = $dailyRate * $this->leaseDays;
        $insuranceTotal = $insuranceRate * $this->leaseDays;
        $serviceFee = round(($leaseTotal + $insuranceTotal) * 0.05, 2);
        $totalAmount = $leaseTotal + $insuranceTotal + $serviceFee;

        $order = Order::query()->create([
            'order_number' => Order::generateOrderNumber(),
            'transaction_id' => Order::generateTransactionId(),
            'customer_id' => $customer->id,
            'container_id' => $this->container->id,
            'insurance_id' => $this->insurance?->id,
            'lease_start' => $this->leaseStart,
            'lease_end' => $this->leaseEnd,
            'lease_days' => $this->leaseDays,
            'daily_rate' => $dailyRate,
            'lease_total' => $leaseTotal,
            'insurance_daily_rate' => $insuranceRate,
            'insurance_total' => $insuranceTotal,
            'service_fee' => $serviceFee,
            'total_amount' => $totalAmount,
            'billing_address' => $this->billingAddress,
            'billing_city' => $this->billingCity,
            'billing_state' => $this->billingState,
            'billing_postcode' => $this->billingPostcode,
            'shipping_address' => $this->shippingAddress,
            'shipping_city' => $this->shippingCity,
            'shipping_state' => $this->shippingState,
            'shipping_postcode' => $this->shippingPostcode,
            'same_as_billing' => $this->sameAsBilling,
            'has_addon' => $this->hasAddon,
            'add_on_remark' => $this->hasAddon ? $this->addOnRemark : null,
            'payment_method' => 'credit_card',
            'payment_status' => 'pending',
            'status' => 'pending',
        ]);

        // Since payment integration is not yet done, simulate success
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'paid_at' => now(),
        ]);

        $this->redirectRoute('customer.orders.payment-success', $order);
    }

    public function render(): View
    {
        $dailyRate = (float) ($this->container->daily_markup ?: $this->container->daily_rate);
        $insuranceRate = (float) ($this->insurance?->daily_rate ?? 0);
        $leaseTotal = $dailyRate * $this->leaseDays;
        $insuranceTotal = $insuranceRate * $this->leaseDays;
        $serviceFee = round(($leaseTotal + $insuranceTotal) * 0.05, 2);
        $grandTotal = $leaseTotal + $insuranceTotal + $serviceFee;

        return view('livewire.customer.orders.order-review-page', compact(
            'dailyRate',
            'insuranceRate',
            'leaseTotal',
            'insuranceTotal',
            'serviceFee',
            'grandTotal',
        ));
    }
}
