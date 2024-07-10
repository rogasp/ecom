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

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function getFlagUrlAttribute()
    {
        $flags = json_decode($this->flags, true);
        $flagUrl = isset($flags['svg']) ? trim($flags['svg']) : null;

        return $flagUrl;
    }

}
