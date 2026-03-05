<?php

use App\Enums\ContainerStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('container', function (Blueprint $table) {
            $table->id();

            // Owner ID
            $table->unsignedBigInteger('owner_id');

            //Display ID
            $table->string('display_id');

            // Basic Information
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('container_type');
            $table->string('container_size');
            $table->string('container_condition');
            $table->string('year_built');
            $table->date('last_inspection_date');
            $table->string('serial_number');

            // Location & Pricing
            $table->string('location');
            $table->string('full_address')->nullable();
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('weekly_rate', 10, 2);
            $table->decimal('monthly_rate', 10, 2);

            // Specifications
            $table->decimal('length', 10, 2);
            $table->decimal('width', 10, 2);
            $table->decimal('height', 10, 2);
            $table->decimal('max_weight', 10, 2);
            $table->decimal('tare_weight', 10, 2);
            $table->decimal('cargo_capacity', 10, 2);

            // Features & Amenities
            $table->text('features')->nullable();

            // Images
            $table->text('images');

            // Status
            $table->string('status')->default(ContainerStatus::Pending);
            $table->string('status_reason')->nullable();
            $table->boolean('unlisted')->default(true);


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container');
    }
};
