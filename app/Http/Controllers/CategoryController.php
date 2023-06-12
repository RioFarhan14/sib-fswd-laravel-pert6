<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {

        $categories = Category::all();

        return view('Category.index', compact('categories'));
    }

    public function create()
    {
        return view('Category.create');
    }

    public function store(Request $request)
    {
        // masukkan data ke database
        $category = Category::create([
            'name' => $request->name
        ]);

        // redirect ke halaman category.index
        return redirect()->route('Category.index');
    }

    public function edit($id)
    {
        // ambil data category berdasarkan id
        $category = Category::find($id);

        // tampilkan view edit dan passing data category
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // ambil data category berdasarkan id
        $category = Category::find($id);

        // update data category
        $category->update([
            'name' => $request->name
        ]);

        // redirect ke halaman category.index
        return redirect()->route('Category.index');
    }

    public function destroy($id)
    {
        // ambil data category berdasarkan id
        $category = Category::find($id);

        // hapus data category
        $category->delete();

        // redirect ke halaman category.index
        return redirect()->route('Category.index');
    }
}
