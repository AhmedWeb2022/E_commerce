<?php

namespace App\Repositories\OrderProduct;

use App\Models\OrderProduct\OrderProduct;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\Repository\RepositoryInterface;


class OrderProductRepository implements RepositoryInterface
{
    protected $orderProduct;

    public function __construct(OrderProduct $orderProduct)
    {
        $this->orderProduct = $orderProduct;
    }

    public function getAll()
    {
        try {
            return OrderProduct::all();
        } catch (Exception $e) {
            // Log the exception and rethrow or return an error message
            Log::error('Error retrieving all order product: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to retrieve order product'], 500);
        }
    }

    public function findById($id)
    {
        try {
            return OrderProduct::find($id);
        } catch (Exception $e) {
            Log::error('Error finding order product by ID: ' . $e->getMessage());
            return null;
        }
    }

    public function create(array $data)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Create the orderProduct in the database
            $orderProduct = OrderProduct::create($data);

            // Commit the transaction if successful
            DB::commit();

            return $orderProduct;
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error creating order product: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create order product'], 500);
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Find the orderProduct
            $orderProduct = $this->findById($id);
            if (!$orderProduct) {
                return response()->json(['error' => 'order product not found'], 404);
            }

            // Update the orderProduct with the provided data
            $orderProduct->update($data);

            // Commit the transaction if successful
            DB::commit();

            return $orderProduct;
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error updating order product: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update order product'], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Find the order product
            $orderProduct = $this->findById($id);
            if (!$orderProduct) {
                return response()->json(['error' => 'order product not found'], 404);
            }

            // Delete the orderProduct
            $orderProduct->delete();

            // Commit the transaction if successful
            DB::commit();

            return response()->json(['message' => 'orderProduct deleted successfully'], 200);
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error deleting orderProduct: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete orderProduct'], 500);
        }
    }
}
