<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'transaction_id',
        'customer_id',
        'container_id',
        'insurance_id',
        'lease_start',
        'lease_end',
        'lease_days',
        'daily_rate',
        'lease_total',
        'insurance_daily_rate',
        'insurance_total',
        'service_fee',
        'total_amount',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'same_as_billing',
        'has_addon',
        'add_on_remark',
        'payment_method',
        'payment_status',
        'status',
        'payment_error',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'lease_start' => 'date',
            'lease_end' => 'date',
            'daily_rate' => 'decimal:2',
            'lease_total' => 'decimal:2',
            'insurance_daily_rate' => 'decimal:2',
            'insurance_total' => 'decimal:2',
            'service_fee' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'same_as_billing' => 'boolean',
            'has_addon' => 'boolean',
            'payment_status' => PaymentStatus::class,
            'status' => OrderStatus::class,
            'paid_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function insurance(): BelongsTo
    {
        return $this->belongsTo(Insurance::class);
    }

    public static function generateOrderNumber(): string
    {
        $year = now()->year;
        $last = static::query()
            ->whereYear('created_at', $year)
            ->withTrashed()
            ->count();

        return sprintf('CZ%d-%03d', $year, $last + 1);
    }

    public static function generateTransactionId(): string
    {
        return 'TXN'.now()->timestamp.random_int(100000, 999999);
    }
}
