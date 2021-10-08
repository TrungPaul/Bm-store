<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function create()
    {
        $categories = Category::select('id','name')->where('status', '=', 1)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // handle model create multiple record
            $this->productService->insert(
                $this->productService->preparingCreate($request->all())
            );
            DB::commit();

            return redirect()->route('category.index')->with('success', @trans('common.created_success'));
        } catch (\Exception $exception)
        {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', @trans('common.error') . $exception->getMessage());
        }
    }
}
