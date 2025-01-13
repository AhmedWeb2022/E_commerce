<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return $this->orderService->getAll();
    }

    public function store(Request $request)
    {
        return $this->orderService->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->orderService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->orderService->delete($id);
    }
}
