<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'geoname_id', 'name', 'ascii_name', 'alternate_names', 'latitude', 'longitude',
        'feature_class', 'feature_code', 'country_code', 'country_id', 'admin1_code',
        'admin2_code', 'admin3_code', 'admin4_code', 'population', 'elevation',
        'digital_elevation_model', 'timezone', 'modification_date', 'country', 'coordinates'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
        // Chain fluent methods for configuration options
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
