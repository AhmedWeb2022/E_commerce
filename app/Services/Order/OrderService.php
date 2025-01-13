<?php

namespace App\Services\Order;

use App\Traits\ApiResponseTrait;
use App\Params\Order\OrderParam;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order\Order;
use App\Repositories\Order\OrderRepository;

class OrderService
{
    use ApiResponseTrait;

    protected $orderParam;
    protected $orderRepository;

    public function __construct(OrderParam $orderParam, OrderRepository $orderRepository)
    {
        $this->orderParam = $orderParam;
        $this->orderRepository = $orderRepository;
    }

    public function getAll()
    {
        $response = $this->orderRepository->getAll();
        if (!$response['status']) {
            return $this->error($response['message']);
        }
        return $this->success(OrderResource::collection($response['data']), 'Orders retrieved successfully');
    }

    public function findById(int $id)
    {
        $response = $this->orderRepository->findById($id);
        if (!$response['status']) {
            return $this->error($response['message']);
        }
        return $this->success(new OrderResource($response['data']), $response['message']);
    }

    public function create(array $data)
    {
        $data['total_amount'] = calculateTotalAmount($data);
        $orderParam = $this->orderParam->setParams($data);
        $response = $this->orderRepository->create($orderParam->toArray());
        $response['data']->products()->attach($data['product_id'], ['quantity' => $data['quantity'], 'price' => $data['price']]);

        if (!$response['status']) {
            return $this->error($response['message']);
        }

        return $this->success(new OrderResource($response['data']), $response['message']);
    }

    public function update(int $id, array $data)
    {
        $data['total_amount'] = calculateTotalAmount($data);
        $orderParam = $this->orderParam->setParams($data);
        $response = $this->orderRepository->update($id, $orderParam->toArray());

        $response['data']->products()->sync([$data['product_id'] => [
            'quantity' => $data['quantity'],
            'price' => $data['price'],
        ]]);

        if (!$response['status']) {
            return $this->error($response['message']);
        }
        return $this->success(new OrderResource($response['data']), 'Order updated successfully');
    }

    public function delete(int $id)
    {
        $response = $this->orderRepository->delete($id);
        if (!$response['status']) {
            return $this->error($response['message']);
        }
        return $this->noContent($response['message'])->getData();
    }
}
