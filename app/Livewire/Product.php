<?php

namespace App\Livewire;

use App\Services\CartManager;
use Livewire\Component;
use App\Models\Product as ProductModel;

class Product extends Component
{
    public ProductModel $product;

    public function render()
    {
        return view('livewire.product');
    }

    public function addToCart(): void
    {
        $cart = app(CartManager::class);
        $cart->add(procductId: $this->product->id);
    }
}
