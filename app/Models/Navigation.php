<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Navigation extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'bg_color',
        'items',
        'items_sidebar',
        'is_active',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
        // Chain fluent methods for configuration options
    }

    protected $casts = [
        'items' => 'array',
        'items_sidebar' => 'array',
    ];
}
