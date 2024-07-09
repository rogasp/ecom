<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Facades\Http;

class UpdateCurrencies extends Command
{
    protected $signature = 'currencies:update';
    protected $description = 'Update currencies from an API';

    public function handle()
    {
        // Hämta fallback-valutan från konfigurationen
        $fallbackCurrency = config('services.fallback_currency');
        $exchangerateApiKey = config('services.exchangerate_api_key');

        // Hämta stödda valutakoder från API:t
        $currencyCodesResponse = Http::get("https://v6.exchangerate-api.com/v6/{$exchangerateApiKey}/codes");

        if (!$currencyCodesResponse->successful()) {
            $this->error('Failed to fetch supported currency codes.');
            return;
        }

        $currencyCodesData = $currencyCodesResponse->json();
        $supportedCodes = $currencyCodesData['supported_codes'] ?? [];

        $currencyCodes = [];
        foreach ($supportedCodes as $code) {
            $currencyCodes[$code[0]] = $code[1];
        }

        // Försök att hämta den valuta som är satt som default
        $defaultCurrency = Currency::where('is_default', true)->first();
        $baseCurrencyIso = $defaultCurrency->iso ?? $fallbackCurrency;

        // Hämta valutakurser baserat på basvalutan
        $response = Http::get("https://open.er-api.com/v6/latest/{$baseCurrencyIso}");

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data['rates'] as $iso => $rate) {
                // Kontrollera om valutainformationen finns i Country-tabellen
                $currencyInfo = $this->getCurrencyInfoFromCountries($iso);

                if (!$currencyInfo) {
                    // Om ingen information hittas i Country-tabellen, använd currencyCodes
                    $currencyName = $currencyCodes[$iso] ?? 'MISSING';
                    $currencySymbol = '??';
                } else {
                    $currencyName = $currencyInfo['name'];
                    $currencySymbol = $currencyInfo['symbol'];
                }

                Currency::updateOrCreate(
                    ['iso' => $iso],
                    [
                        'name' => $currencyName,
                        'symbol' => $currencySymbol,
                        'exchange_rate' => $rate,
                        'last_updated' => now(),
                    ]
                );
            }

            $this->info('Currencies updated successfully.');
        } else {
            $this->error('Failed to fetch currency data.');
        }
    }

    /**
     * Hämta valutainformation från Country-tabellen.
     *
     * @param string $iso
     * @return array|null
     */
    private function getCurrencyInfoFromCountries($iso)
    {
        $country = Country::where('currencies', 'like', '%"'.$iso.'"%')->first();
        if ($country) {
            $currencies = json_decode($country->currencies, true);
            if (isset($currencies[$iso])) {
                return [
                    'name' => $currencies[$iso]['name'] ?? 'MISSING',
                    'symbol' => $currencies[$iso]['symbol'] ?? '??'
                ];
            }
        }
        return null;
    }
}
