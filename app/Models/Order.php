<?php

namespace App\Models;

use App\Enums\OrderStatus; // Importera din OrderStatus enum
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'order_id',
        'user_id',
        'taxes',
        'discount',
        'total',
        'status',
        'shipping_method',
        'shipping_cost',
        'customer_notes',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => OrderStatus::class, // Casta status till din enum
    ];

    // Relation till användaren som gjorde beställningen
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relation till alla orderrader i beställningen
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
