<?php

use App\Enums\ProductStatus;
use App\Enums\ProductType;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('sku')->unique();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('available_at')->nullable();
            $table->integer('price');
            $table->enum('status', ProductStatus::values())->default(ProductStatus::PENDING);
            $table->enum('product_type', ProductType::values())->default(ProductType::PHYSICAL);
            $table->integer('weight')->default(0); // Vikt i gram
            $table->json('dimensions')->nullable(); // Bredd, höjd, längd
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->string('canonical_url')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('slug');
            $table->index('sku');
            $table->index('published_at');
            $table->index('available_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
