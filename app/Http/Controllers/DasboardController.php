<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DasboardController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        if (Auth::user()->role->name == 'user') {
            return view('Product.card', ['products' => $products]);
        } else {
            return view('Dasboard');
        }
    }
}
