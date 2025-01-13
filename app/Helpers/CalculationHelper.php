<?php

function calculateTotalAmount(array $data)
{
    $subtotal = $data['quantity'] * $data['price'];
    $tax = $subtotal * 0.10; // 10% tax
    $totalAmount = $subtotal + $tax;

    return $totalAmount;
}
