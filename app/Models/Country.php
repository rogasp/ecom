<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Country extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
        'tld',
        'cca2',
        'ccn3',
        'cca3',
        'cioc',
        'independent',
        'status',
        'un_member',
        'currencies',
        'idd',
        'capital',
        'altSpellings',
        'region',
        'subregion',
        'languages',
        'translations',
        'latlng',
        'landlocked',
        'area',
        'demonyms',
        'flag',
        'maps',
        'population',
        'gini',
        'fifa',
        'car',
        'timezones',
        'continents',
        'flags',
        'coatOfArms',
        'startOfWeek',
        'capitalInfo',
        'postalCode',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
        // Chain fluent methods for configuration options
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_iso', 'iso');
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function getZipFormatAttribute()
    {
        $zipFormat = json_decode($this->postalCode, true);
        return isset($zipFormat['format']) ? trim($zipFormat['format']) : null;
    }

    public function getFlagUrlAttribute()
    {
        $flags = json_decode($this->flags, true);
        return isset($flags['svg']) ? trim($flags['svg']) : null;
    }

    public function getCoatOfArmsUrlAttribute()
    {
        $coatOfArms = json_decode($this->coatOfArms, true);
        return isset($coatOfArms['png']) ? trim($coatOfArms['png']) : null;
    }

}
