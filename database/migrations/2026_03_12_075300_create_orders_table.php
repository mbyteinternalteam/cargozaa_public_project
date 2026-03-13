<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('transaction_id')->nullable()->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('container_id')->constrained('container')->cascadeOnDelete();
            $table->foreignId('insurance_id')->nullable()->constrained()->nullOnDelete();

            $table->date('lease_start');
            $table->date('lease_end');
            $table->integer('lease_days');

            $table->decimal('daily_rate', 10, 2);
            $table->decimal('lease_total', 10, 2);
            $table->decimal('insurance_daily_rate', 10, 2)->default(0);
            $table->decimal('insurance_total', 10, 2)->default(0);
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_postcode')->nullable();

            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->boolean('same_as_billing')->default(true);

            $table->boolean('has_addon')->default(false);
            $table->text('add_on_remark')->nullable();

            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('status')->default('pending');
            $table->text('payment_error')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
