<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Country extends Model
{
    use HasFactory;

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_iso', 'iso');
    }

    public function getFlagUrlAttribute()
    {
        $flags = json_decode($this->flags, true);
        $flagUrl = isset($flags['svg']) ? trim($flags['svg']) : null;

        return $flagUrl;
    }

    public function getCommonNameAttribute()
    {
        $translations = json_decode($this->translations, true);
        $locale = App::getLocale();

        // Översätt Filament-språk till ISO-koder
        $isoLocales = [
            'sv' => 'swe',
            // Lägg till fler översättningar här
        ];

        $isoLocale = $isoLocales[$locale] ?? null;

        // Returnera översättningen på det valda språket eller använd fallback
        return $translations[$isoLocale]['common'] ?? $this->getCommonName();
    }

    public function getCommonName()
    {
        $name = json_decode($this->name, true);
        return $name['common'] ?? null;
    }

}
