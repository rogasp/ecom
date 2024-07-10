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
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            // 1. Skapa en temporär kolumn med datatypen string
            $table->string('temp_capital')->nullable();
        });

        // 2. Kopiera första värdet från JSON-arrayen till den temporära kolumnen
        DB::table('countries')->get()->each(function ($row) {
            if (property_exists($row, 'capital') && !is_null($row->capital)) {
                $capitalArray = json_decode($row->capital);
                if (is_array($capitalArray) && !empty($capitalArray)) {
                    $capital = $capitalArray[0]; // Extrahera första elementet som text
                    DB::table('countries')
                        ->where('id', $row->id)
                        ->update(['temp_capital' => $capital]);
                }
            }
        });

        Schema::table('countries', function (Blueprint $table) {
            // 3. Ta bort den gamla JSON-kolumnen
            $table->dropColumn('capital');

            // 4. Byt namn på den temporära kolumnen till det ursprungliga namnet
            $table->renameColumn('temp_capital', 'capital');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            // 1. Skapa en temporär kolumn för att hålla JSON-värdena
            $table->json('temp_capital')->nullable();
        });

        // 2. Kopiera tillbaka värden från 'capital' till 'temp_capital' i JSON-format
        DB::table('countries')->get()->each(function ($row) {
            if (property_exists($row, 'capital') && !is_null($row->capital)) {
                $capitalJson = json_encode([$row->capital]);
                DB::table('countries')
                    ->where('id', $row->id)
                    ->update(['temp_capital' => $capitalJson]);
            }
        });

        Schema::table('countries', function (Blueprint $table) {
            // 3. Ta bort den ändrade kolumnen 'capital'
            $table->dropColumn('capital');

            // 4. Byt namn på 'temp_capital' tillbaka till 'capital'
            $table->renameColumn('temp_capital', 'capital');
        });
    }
};
