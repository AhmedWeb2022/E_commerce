<?php

namespace App\Repositories\Order;

use Exception;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\Repository\RepositoryInterface;

class OrderRepository  implements RepositoryInterface
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    public function getAll()
    {
        try {
            return Order::all();
        } catch (Exception $e) {
            // Log the exception and rethrow or return an error message
            Log::error('Error retrieving all orders: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to retrieve orders'], 500);
        }
    }

    public function findById($id)
    {
        try {
            return Order::find($id);
        } catch (Exception $e) {
            Log::error('Error finding order by ID: ' . $e->getMessage());
            return null;
        }
    }

    public function create(array $data)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Create the order in the database
            $order = Order::create($data);

            // Commit the transaction if successful
            DB::commit();

            return $order;
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error creating order: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create order'], 500);
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Find the order
            $order = $this->findById($id);
            if (!$order) {
                return response()->json(['error' => 'order not found'], 404);
            }

            // Update the order with the provided data
            $order->update($data);

            // Commit the transaction if successful
            DB::commit();

            return $order;
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error updating order: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update order'], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Find the order
            $order = $this->findById($id);
            if (!$order) {
                return response()->json(['error' => 'order not found'], 404);
            }

            // Delete the order
            $order->delete();

            // Commit the transaction if successful
            DB::commit();

            return response()->json(['message' => 'order deleted successfully'], 200);
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error deleting order: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete order'], 500);
        }
    }
}
