<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        if (Auth::user()->role->name == 'user') {
            return view('Product.card', ['products' => $products]);
        } else {
            return view('Product.index', ['products' => $products]);
        }
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();

        return view('product.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required|string|min:3',
            'price' => 'required|integer',
            'sale_price' => 'required|integer',
            'brand' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'category.required' => 'Kolom kategori harus diisi.',
            'name.required' => 'Kolom nama harus diisi.',
            'name.string' => 'Kolom nama harus berupa teks.',
            'name.min' => 'Kolom nama minimal diisi 3 karakter.',
            'price.required' => 'Kolom harga harus diisi.',
            'price.integer' => 'Kolom harga harus berupa angka.',
            'sale_price.required' => 'Kolom harga jual harus diisi.',
            'sale_price.integer' => 'Kolom harga jual harus berupa angka.',
            'brand.required' => 'Kolom merek harus diisi.',
            'brand.string' => 'Kolom merek harus berupa teks.',
            'image.required' => 'Kolom gambar harus diisi.',
            'image.image' => 'Kolom gambar harus berupa file gambar.',
            'image.mimes' => 'Kolom gambar harus memiliki format file jpeg, png, atau jpg.',
            'image.max' => 'Ukuran file gambar tidak boleh melebihi 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // ubah nama file
        $imageName = time() . '.' . $request->image->extension();

        // simpan file ke folder public/product
        Storage::putFileAs('public/product', $request->image, $imageName);

        $product = Product::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'brands' => $request->brand,
            'image' => $imageName,
        ]);

        return redirect()->route('Product.index');
    }

    public function edit($id)
    {
        // ambil data product berdasarkan id
        $product = Product::where('id', $id)->with('category')->first();

        // ambil data brand dan category sebagai isian di pilihan (select)
        $brands = Brand::all();
        $categories = Category::all();

        // tampilkan view edit dan passing data product
        return view('product.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required|string|min:3',
            'price' => 'required|integer',
            'sale_price' => 'required|integer',
            'brand' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'category.required' => 'Kolom kategori harus diisi.',
            'name.required' => 'Kolom nama harus diisi.',
            'name.string' => 'Kolom nama harus berupa teks.',
            'name.min' => 'Kolom nama minimal diisi 3 karakter.',
            'price.required' => 'Kolom harga harus diisi.',
            'price.integer' => 'Kolom harga harus berupa angka.',
            'sale_price.required' => 'Kolom harga jual harus diisi.',
            'sale_price.integer' => 'Kolom harga jual harus berupa angka.',
            'brand.required' => 'Kolom merek harus diisi.',
            'brand.string' => 'Kolom merek harus berupa teks.',
            'image.required' => 'Kolom gambar harus diisi.',
            'image.image' => 'Kolom gambar harus berupa file gambar.',
            'image.mimes' => 'Kolom gambar harus memiliki format file jpeg, png, atau jpg.',
            'image.max' => 'Ukuran file gambar tidak boleh melebihi 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // cek jika user mengupload gambar di form
        if ($request->hasFile('image')) {
            // ambil nama file gambar lama dari database
            $old_image = Product::find($id)->image;

            // hapus file gambar lama dari folder slider
            Storage::delete('public/product/' . $old_image);

            // ubah nama file
            $imageName = time() . '.' . $request->image->extension();

            // simpan file ke folder public/product
            Storage::putFileAs('public/product', $request->image, $imageName);

            // update data product
            Product::where('id', $id)->update([
                'category_id' => $request->category,
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'brands' => $request->brand,
                'image' => $imageName,
            ]);
        } else {
            // update data product tanpa menyertakan file gambar
            Product::where('id', $id)->update([
                'category_id' => $request->category,
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'brands' => $request->brand,
            ]);
        }

        // redirect ke halaman Product.index
        return redirect()->route('Product.index');
    }

    public function destroy($id)
    {
        // ambil data product berdasarkan id
        $product = Product::find($id);

        // hapus data product
        $product->delete();

        // redirect ke halaman Product.index
        return redirect()->route('Product.index');
    }
}
