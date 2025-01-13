<?php

namespace App\Services\Order;

use App\Params\Order\OrderParam;
use App\Repositories\Order\OrderRepository;

class OrderService
{
    protected $orderParam;
    protected $orderRepository;

    public function __construct(OrderParam $orderParam, OrderRepository $orderRepository)
    {
        $this->orderParam = $orderParam;
        $this->orderRepository = $orderRepository;
    }

    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function findById($id)
    {
        return $this->orderRepository->findById($id);
    }

    public function create(array $data)
    {
        $orderParam = $this->orderParam->setParams($data);
        return $this->orderRepository->create($orderParam->toArray());
    }

    public function update($id, array $data)
    {
        $orderParam = $this->orderParam->setParams($data);
        return $this->orderRepository->update($id, $orderParam->toArray());
    }

    public function delete($id)
    {
        return $this->orderRepository->delete($id);
    }
}
