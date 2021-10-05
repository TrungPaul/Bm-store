<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $requestData = $request->all();
        $categories = $this->categoryService->getAllWithFilter($requestData);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->categoryService->create(
                $this->categoryService->preparingCreateOrUpdate($request->validated())
            );
            DB::commit();

            return redirect()->route('category.index')->with('success', @trans('common.created_success'));
        } catch (\Exception $exception)
        {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', @trans('common.error') . $exception->getMessage());
        }

    }

    public function edit(int $id)
    {
        $category = $this->categoryService->find($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(CreateCategoryRequest $request, int $id)
    {
        try {
            DB::beginTransaction();
            $this->categoryService->update(
                $this->categoryService->preparingCreateOrUpdate($request->validated()), $id
            );
            DB::commit();

            return redirect()->route('category.index')->with('success', @trans('common.updated_success'));
        } catch (\Exception $exception)
        {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', @trans('common.error') . $exception->getMessage());
        }
    }
}
