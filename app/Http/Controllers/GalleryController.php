<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GalleryController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        return Inertia::render('Gallery', [
            'products' => $products,
            'categories' => $categories,
            'csrf_token' => csrf_token(),
        ]);
    }
    
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return Inertia::render('GalleryDetail', [
            'product' => $product,
            'auth' => [
                'user' => auth()->user() ? [
                    'id' => auth()->user()->id,
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ] : null,
            ],
            'csrf_token' => csrf_token(),
        ]);
    }
}