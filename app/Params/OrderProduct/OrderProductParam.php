<?php


namespace App\Params\OrderProduct;


class OrderProductParam
{
    public $product_id;
    public $order_id;
    public $quantity;
    public $price;


    public function __construct(array $data = [])
    {
        $this->product_id = $data['product_id'] ?? null;
        $this->order_id = $data['order_id'] ?? null;
        $this->quantity = $data['quantity'] ?? 0;
        $this->price = $data['price'] ?? 0;
    }

    public function setParams(array $data)
    {
        $this->product_id = $data['product_id'] ?? null;
        $this->order_id = $data['order_id'] ?? null;
        $this->quantity = $data['quantity'] ?? 0;
        $this->price = $data['price'] ?? 0;
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'order_id' => $this->order_id,
            'quantity' => $this->quantity,
            'price' => $this->price
        ];
    }
}
