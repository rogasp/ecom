<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->string('common_name')->nullable();
        });

        DB::table('countries')->get()->each(function ($row) {
            $jsonData = json_decode($row->name, true);
            $name = $jsonData['common'];
            DB::table('countries')
                ->where('id', $row->id)
                ->update(['common_name' => $name]);
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->string('common_name')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('country', function (Blueprint $table) {
            $table->dropColumn('common_name');
        });
    }
};
