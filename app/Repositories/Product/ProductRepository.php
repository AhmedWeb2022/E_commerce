<?php

namespace App\Repositories\Product;

use Exception;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\Repository\RepositoryInterface;

class ProductRepository implements RepositoryInterface
{

    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function getAll()
    {
        try {
            $products = Product::all();

            return [
                'status' => true,
                'message' => 'Products retrieved successfully',
                'data' => $products
            ];
        } catch (Exception $e) {
            // Log the exception and rethrow or return an error message
            Log::error('Error retrieving all products: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error retrieving all products'
            ];
        }
    }

    public function findById($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return [
                    'status' => false,
                    'message' => 'Product not found'
                ];
            }
            return [
                'status' => true,
                'message' => 'Product retrieved successfully',
                'data' => $product
            ];
        } catch (Exception $e) {
            Log::error('Error finding product by ID: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error finding product'
            ];
        }
    }

    public function create(array $data)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Create the product in the database
            $product = Product::create($data);

            // Commit the transaction if successful
            DB::commit();

            return [
                'status' => true,
                'message' => 'Product created successfully',
                'data' => $product
            ];
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error creating product: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Unable to create product'
            ];
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Find the product
            $product = $this->findById($id)["data"];
            if (!$product) {
                return [
                    'status' => false,
                    'message' => 'Product not found'
                ];
            }

            // Update the product with the provided data
            $product->update($data);

            // Commit the transaction if successful
            DB::commit();

            return [
                'status' => true,
                'message' => 'Product updated successfully',
                'data' => $product
            ];
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error updating product: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Unable to update product'
            ];
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Find the product
            $product = $this->findById($id)["data"];
            if (!$product) {
                return [
                    'status' => false,
                    'message' => 'Product not found'
                ];
            }

            // Delete the product
            $product->delete();

            // Commit the transaction if successful
            DB::commit();

            return [
                'status' => true,
                'message' => 'Product deleted successfully'
            ];
        } catch (Exception $e) {
            // Rollback the transaction if anything goes wrong
            DB::rollBack();

            // Log the error and return a meaningful response
            Log::error('Error deleting product: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Unable to delete product'
            ];
        }
    }
}
