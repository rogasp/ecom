<?php

namespace App\Models;

use App\Jobs\UpdateCurrenciesJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'iso', 'name', 'symbol', 'symbol_position', 'is_active', 'last_updated', 'exchange_rate', 'is_default'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
        // Chain fluent methods for configuration options
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }


    // Ensure only one default currency
    public static function boot()
    {
        parent::boot();

        static::creating(function ($currency) {
            if ($currency->is_default) {
                static::where('is_default', true)->update(['is_default' => false]);
            }
        });

        static::updating(function ($currency) {
            if ($currency->is_default) {
                static::where('is_default', true)
                    ->where('id', '!=', $currency->id)
                    ->update(['is_default' => false]);
            }
        });

        static::updated(function ($currency) {
            if ($currency->wasChanged('is_default') && $currency->is_default) {
                UpdateCurrenciesJob::dispatch();
            }
        });
    }
}
