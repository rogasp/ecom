<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $response = Http::get('https://restcountries.com/v3.1/all'); // Ersätt 'API_URL' med den faktiska API-URL:en
        $countries = $response->json();

        foreach ($countries as $country) {
            try {
                if (isset($country['currencies']) && is_array($country['currencies'])) {
                    $currencyKeys = array_keys($country['currencies']);
                    $currencyCode = $currencyKeys[0] ?? null;
                    $currencyInfo = $country['currencies'][$currencyCode] ?? null;

                    if ($currencyCode && $currencyInfo) {
                        // Skapa eller hämta valutan
                        $currency = Currency::firstOrCreate(
                            ['iso' => $currencyCode],
                            [
                                'name' => $currencyInfo['name'],
                                'symbol' => $currencyInfo['symbol'],
                                'symbol_position' => 'left',
                                'is_active' => true,
                                'last_updated' => now(),
                                'exchange_rate' => null,
                                'is_default' => false,
                            ]
                        );
                    }
                } else {
                    $currencyCode = null;
                    Log::warning('Currency code not found for country', ['country' => $country]);
                }

                Country::updateOrCreate(
                    ['cca3' => $country['cca3']], // Matcha på detta attribut
                    [ // Uppdatera eller skapa med dessa värden
                        'name' => json_encode($country['name']),
                        'tld' => json_encode($country['tld']),
                        'cca2' => $country['cca2'],
                        'ccn3' => $country['ccn3'],
                        'cioc' => $country['cioc'] ?? null,
                        'independent' => $country['independent'],
                        'status' => $country['status'],
                        'un_member' => $country['unMember'],
                        'currency_iso' => $currencyCode,
                        'currencies' => json_encode($country['currencies']),
                        'idd' => json_encode($country['idd']),
                        'capital' => json_encode($country['capital']),
                        'altSpellings' => json_encode($country['altSpellings']),
                        'region' => $country['region'],
                        'subregion' => $country['subregion'] ?? null,
                        'languages' => json_encode($country['languages']),
                        'translations' => json_encode($country['translations']),
                        'latlng' => json_encode($country['latlng']),
                        'landlocked' => $country['landlocked'],
                        'area' => $country['area'],
                        'demonyms' => json_encode($country['demonyms']),
                        'flag' => $country['flag'],
                        'maps' => json_encode($country['maps']),
                        'population' => $country['population'],
                        'gini' => json_encode($country['gini'] ?? null),
                        'fifa' => $country['fifa'] ?? null,
                        'car' => json_encode($country['car']),
                        'timezones' => json_encode($country['timezones']),
                        'continents' => json_encode($country['continents']),
                        'flags' => json_encode($country['flags']),
                        'coatOfArms' => json_encode($country['coatOfArms'] ?? null),
                        'startOfWeek' => $country['startOfWeek'],
                        'capitalInfo' => json_encode($country['capitalInfo'] ?? null),
                        'postalCode' => json_encode($country['postalCode'] ?? null),
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Failed to insert or update country', ['country' => $country, 'error' => $e->getMessage()]);
            }
        }
    }
}
