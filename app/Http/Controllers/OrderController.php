<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $requestData = $request->all();
        $orders = $this->orderService->getAllWithFilter($requestData);

        return view('user.orders.index', compact('orders'));
    }
}
