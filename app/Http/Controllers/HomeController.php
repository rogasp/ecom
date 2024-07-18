<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartManager;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //dd(app(CartManager::class   ));
        return view('home', [
            ''
    ]);
    }
}
