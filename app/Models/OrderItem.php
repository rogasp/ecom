<?php

namespace App\Models;

use App\Enums\OrderItemStatus; // Importera din OrderItemStatus enum
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'reserved_quantity',
        'picked_quantity',
        'status', // Nytt fält
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => OrderItemStatus::class, // Casta status till din enum
    ];

    // Relation till ordern som raden tillhör
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Relation till produkten som raden representerar
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scope för att hämta rader med en specifik status
    public function scopeWithStatus($query, OrderItemStatus $status)
    {
        return $query->where('status', $status);
    }
}
