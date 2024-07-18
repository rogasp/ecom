<?php

namespace App\Services;
use App\Models\Cart;
use App\Services\Contracts\CartManager as CartInterface;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use function Pest\Laravel\instance;

class CartManager implements CartInterface
{
    protected $cart;
    protected $session;
    
    protected function __construct(protected SessionManager $sessionManager)
    {
        $this->session = $this->sessionManager->driver();
        $this->cart = $this->getOrCreateCart();
    }

    public function exists(): bool
    {
        return $this->session->has(config('cart.session.cart_key')) && $this->cart;
    }
    protected function getOrCreateCart()
    {
        //$this->session->forget('cart_id');
        $cartId = $this->session->get('cart_id');

        if($cartId) {
            $cart = Cart::where('cart_id', $cartId)->first();

            if(Auth::check() && is_null($cart->user_id)) {
                $cart->user_id = Auth::id();
                $cart->save();
            }
        } else {
            $cart = Cart::create([
                'cart_id' => Str::uuid(),
                'user_id' => Auth::id() ?? null
            ]);

            $this->session->put('cart_id', $cart->cart_id);
            $this->session->save();

        }

        return $cart;
    }
    public function add()
    {

    }

    public function remove()
    {

    }

    public function update()
    {

    }

    public function getCart()
    {

    }

    public function getSubtotal()
    {

    }
}
