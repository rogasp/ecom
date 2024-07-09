<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'iso', 'name', 'symbol', 'symbol_position', 'is_active', 'last_updated', 'exchange_rate', 'is_default'
    ];

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    // Ensure only one default currency
    public static function boot()
    {
        parent::boot();

        static::saving(function ($currency) {
            if ($currency->is_default) {
                static::where('is_default', true)->update(['is_default' => false]);
            }
        });
    }
}
