<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Country;
use League\Csv\Reader;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath(database_path('seeders/cities.csv'), 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        foreach ($csv as $record) {
            #dd($record);
            $country = Country::where('cca2', $record['Country Code'])->first();

            if ($country) {
                City::updateOrCreate(
                    ['geoname_id' => $record['Geoname ID']],
                    ['geoname_id' => $record['Geoname ID'],
                        'name' => $record['Name'],
                        'ascii_name' => $record['ASCII Name'],
                        'alternate_names' => $record['Alternate Names'] ?: null,
                        'latitude' => $record['Latitude'],
                        'longitude' => $record['Longitude'],
                        'feature_class' => $record['Feature Class'] ?: null,
                        'feature_code' => $record['Feature Code'] ?: null,
                        'country_code' => $record['Country Code'],
                        'country_id' => $country->id,
                        'admin1_code' => $record['Admin1 Code'] ?: null,
                        'admin2_code' => $record['Admin2 Code'] ?: null,
                        'admin3_code' => $record['Admin3 Code'] ?: null,
                        'admin4_code' => $record['Admin4 Code'] ?: null,
                        'population' => $record['Population'] ?: null,
                        'elevation' => $record['Elevation'] ?: null,
                        'digital_elevation_model' => $record['DIgital Elevation Model'] ?: null,
                        'timezone' => $record['Timezone'] ?: null,
                        'modification_date' => $record['Modification date'] ?: null,
                        'country' => $record['Country'],
                        'coordinates' => $record['Coordinates'] ?: null,
                    ]);
            }
        }
    }
}
