<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->references('id')->on('users');
            $table->foreignId('service_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->references('id')->on('services');
            $table->enum('status', ['Pending', 'On Going', 'Completed', 'Cancelled'])->default('Pending');
            // $table->float('total_price');
            $table->string('file_url');
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });

        Schema::create('order_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_service');
        Schema::dropIfExists('orders');
    }
};
