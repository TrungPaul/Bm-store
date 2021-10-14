<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create()
    {
        $categories = Category::select('id','name')->where('status', '=', 1)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(CreateProductRequest $request)
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
