<?php

namespace App\Services\Contracts;

interface CartManager
{
    public function add();

    public function remove();

    public function update();

    public function getCart();

    public function getSubtotal();

}
