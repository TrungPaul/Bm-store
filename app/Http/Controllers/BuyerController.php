<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', config('constants.active'))->get();
//        dd($categories->where('type', 1)->first());
        $products = Product::where('status', 1)->get();
        return view('user.index', compact('categories', 'products'));
    }
}
