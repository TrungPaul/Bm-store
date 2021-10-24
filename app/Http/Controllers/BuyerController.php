<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Txn;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuyerController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $categories = Category::where('status', config('constants.active'))->get();
        return view('user.index', compact('categories'));
    }

    public function buyProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'per_page' => 'required|gt:0'
        ]);
        $request['status'] = Product::STATUS_ACTIVE;
        $requestData = $request->all();
        $products = $this->productService->getAllWithFilter($requestData, [], 'ASC', 'id', true);
        $price = Category::find($request->category_id)->price;
        $totalMoney = $price*$request->per_page;

        if ((int) $totalMoney > (int)Auth::user()->balance) {
            return response()->json([
                'code' => 400,
                'message' => 'Số dư không đủ',
            ]);
        }

        if (empty($products->items()) || $request->per_page > $products->total()) {
            return response()->json([
                'code' => 400,
                'message' => 'Số lượng sản phẩm mua không hợp lệ',
            ], 400);
        }
        // update Product has bought
        try {
            DB::beginTransaction();
            Product::whereIn('id', $products->pluck('id')->toArray())->update([
                'id_user_buy' => Auth::id(),
                'status' => Product::STATUS_BOUGHT
            ]);
            // trừ tiền
            $txn = new Txn([
                'user_id' => Auth::id(),
                'amount' => (int) $totalMoney*(-1),
                'type' => config('constants.txn.type.payment'),
                'status' => Txn::STAT_COMPLETED,
            ]);
            $txn->save();

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Mua thành công'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'code' => 400,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function bought(Request $request)
    {
        $request['status'] = Product::STATUS_BOUGHT;
        $request['id_user_buy'] = Auth::id();
        $requestData = $request->all();
        $products = $this->productService->getAllWithFilter($requestData, [], 'DESC', 'updated_at', false);
        $products = $this->paginateHistoryBought($products->groupBy('category_id'));

        return view('user.history_bought.index', compact('products'));
    }

    public function paginateHistoryBought($items, $perPage = 2, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => route('buyer.bought'), 'pageName' => 'page']);
    }

    public function download(Request $request, int $id)
    {
        $request['status'] = Product::STATUS_BOUGHT;
        $request['id_user_buy'] = Auth::id();
        $request['category_id'] = $id;
        $requestData = $request->all();
        $products = $this->productService->getAllWithFilter($requestData, [], 'ASC', 'updated_at', true);

        $content = "";
        foreach ($products->items() as $product) {
            $content.= $product->data;
            $content .= "\n";
        }

        $fileName = time();
        return response($content)
            ->withHeaders([
                'Content-Type' => 'text/plain',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'attachment; filename=' . $fileName . '.txt',
            ]);
    }
}
