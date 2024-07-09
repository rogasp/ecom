<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('tld');
            $table->string('cca2', 2);
            $table->string('ccn3', 3);
            $table->string('cca3', 3);
            $table->string('cioc', 3)->nullable();
            $table->boolean('independent');
            $table->string('status');
            $table->boolean('un_member');
            $table->json('currencies');
            $table->json('idd');
            $table->json('capital');
            $table->json('altSpellings');
            $table->string('region');
            $table->string('subregion')->nullable();
            $table->json('languages');
            $table->json('translations');
            $table->json('latlng');
            $table->boolean('landlocked');
            $table->float('area');
            $table->json('demonyms');
            $table->string('flag');
            $table->json('maps');
            $table->integer('population');
            $table->json('gini')->nullable();
            $table->string('fifa', 3)->nullable();
            $table->json('car');
            $table->json('timezones');
            $table->json('continents');
            $table->json('flags');
            $table->json('coatOfArms')->nullable();
            $table->string('startOfWeek');
            $table->json('capitalInfo')->nullable();
            $table->json('postalCode')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
