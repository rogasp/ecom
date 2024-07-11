<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bg_color',
        'items',
        'items_sidebar',
        'is_active',
    ];

    protected $casts = [
        'items' => 'array',
        'items_sidebar' => 'array',
    ];
}
