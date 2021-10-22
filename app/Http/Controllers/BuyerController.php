<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Txn;
use App\Services\ProductService;
use Illuminate\Http\Request;
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
        $price = Category::find(6)->price;
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

    public function bought()
    {
        //@Todo: redirect page history buy
        return redirect()->route('buyer.index');
    }
}
