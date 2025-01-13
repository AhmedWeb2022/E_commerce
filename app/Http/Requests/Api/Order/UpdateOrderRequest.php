<?php

namespace App\Http\Requests\Api\Order;

use App\Response\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'product_ids' => 'required|array',
            'product_id' => 'required|exists:products,id',
            // 'quantities' => 'required|array',
            'quantity' => 'required|numeric',
            // 'prices' => 'required|array',
            'price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            // 'product_ids.required' => 'Product ids are required',
            // 'product_ids.*.array' => 'Product ids must be an array',
            // 'product_ids.*.exists' => 'Product does not exist',
            // 'quantities.required' => 'Quantities are required',
            // 'quantities.*.array' => 'Quantities must be an array',
            // 'quantities.*.numeric' => 'Quantities must be a number',
            // 'prices.required' => 'Prices are required',
            // 'prices.*.array' => 'Prices must be an array',
            // 'prices.*.numeric' => 'Prices must be a number',

            'product_id.required' => 'Product id is required',
            'product_id.exists' => 'Product does not exist',
            'quantity.required' => 'Quantity is required',
            'quantity.numeric' => 'Quantity must be a number',
            'price.required' => 'Price is required',
        ];
    }
}
