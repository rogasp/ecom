<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'geoname_id', 'name', 'ascii_name', 'alternate_names', 'latitude', 'longitude',
        'feature_class', 'feature_code', 'country_code', 'country_id', 'admin1_code',
        'admin2_code', 'admin3_code', 'admin4_code', 'population', 'elevation',
        'digital_elevation_model', 'timezone', 'modification_date', 'country', 'coordinates'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
