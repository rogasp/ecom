<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'sku',
        'published_at',
        'available_at',
        'price',
        'status',
        'product_type',
        'weight',
        'dimensions',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    // Scope för publicerade produkter
    public function scopePublished($query)
    {
        return $query->where('status', ProductStatus::PUBLISHED);
    }

    // Scope för tillgängliga produkter
    public function scopeAvailable($query)
    {
        return $query->published()->where('available_at', '<=', now());
    }

    protected $casts = [
        'dimensions' => 'array', // Casta dimensions till en array
    ];

}
