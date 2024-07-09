<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('geoname_id')->unique();
            $table->string('name');
            $table->string('ascii_name');
            $table->text('alternate_names')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('feature_class')->nullable();
            $table->string('feature_code')->nullable();
            $table->string('country_code')->nullable();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('admin1_code')->nullable();
            $table->string('admin2_code')->nullable();
            $table->string('admin3_code')->nullable();
            $table->string('admin4_code')->nullable();
            $table->integer('population')->nullable();
            $table->integer('elevation')->nullable();
            $table->integer('digital_elevation_model')->nullable();
            $table->string('timezone')->nullable();
            $table->date('modification_date')->nullable();
            $table->string('country')->nullable();
            $table->string('coordinates')->nullable();
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
        Schema::dropIfExists('cities');
    }
}
