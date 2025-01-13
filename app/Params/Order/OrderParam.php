<?php


namespace App\Params\Order;


class OrderParam
{
    public $total_amount;
    public $status;


    public function __construct(array $data = [])
    {
        $this->total_amount = $data['total_amount'] ?? null;
        $this->status = $data['status'] ?? 0;
    }

    public function setParams(array $data)
    {
        $this->total_amount = $data['total_amount'] ?? null;
        $this->status = $data['status'] ?? 0;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'total_amount' => $this->total_amount,
            'status' => $this->status
        ];
    }
}
