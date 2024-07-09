<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('iso', 3)->unique();
            $table->string('name');
            $table->string('symbol');
            $table->enum('symbol_position', ['left', 'right'])->default('left');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_updated')->nullable();
            $table->decimal('exchange_rate', 15, 8)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
