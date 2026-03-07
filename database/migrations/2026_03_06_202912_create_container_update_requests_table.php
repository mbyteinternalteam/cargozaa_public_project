<?php

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
        Schema::create('container_update_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_id')->constrained('container')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->json('data');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_update_requests');
    }
};
