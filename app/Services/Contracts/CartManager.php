<?php

namespace App\Services\Contracts;

use App\Models\User;

interface CartManager
{
    public function add($procductId, $quantity);

    public function exists();

    public function associateWithUser();

    public function create(?User $user);

    public function remove();

    public function update();

    public function getCart();

    public function getSubtotal();

}
