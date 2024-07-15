<?php

use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_id');
            $table->string('email');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->integer('taxes')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('total');
            $table->enum('status', OrderStatus::values())->default(OrderStatus::PROCESSING); // Nytt fält
            $table->string('shipping_method')->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->text('customer_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('email');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
