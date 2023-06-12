<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DasboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter berdasarkan nama produk
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->input('category'));
            });
        }

        // Filter berdasarkan merek
        if ($request->has('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        // Eksekusi query dan ambil hasilnya
        $products = $query->with('category')->get();
        if (Auth::user()->role->name == 'user') {
            return view('Product.card', ['products' => $products]);
        } else {
            return view('Dasboard');
        }
    }
}
