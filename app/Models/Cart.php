<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'user_id',
    ];

    public function add($cartID, $quantity, $productID)
    {
        $item = $this->items()
            ->where('cart_id', $cartID)
            ->where('product_id', $productID)
            ->first();

        if($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $this->items()->create([
                'product_id' => $productID,
                'quantity' => $quantity,
            ]);
        }

    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
