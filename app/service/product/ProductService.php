<?php

namespace App\Service\Product;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function new(string $name, string $description): array
    {
        try {
            DB::insert("INSERT INTO products (name, description) VALUES (?, ?)", [$name, $description]);
        } catch (QueryException $qe) {
            $errorMsg = "";
            switch ($qe->getCode()){
                case 22001:
                    $errorMsg = "Name is too long (max 64 characters)";
                    break;
                case 23000:
                    $errorMsg = "Product name must be unique";
                    break;
                default:
                    $errorMsg = "Unknown error, code: " . $qe->getCode();
                    break;
            }

            return ["returnType" => 'error', "message" => 'Invalid product: ' . $errorMsg];
        }

        return ["returnType" => 'status', "message" => 'Product saved'];
    }

    public function delete(int $productId)
    {
        try {
            DB::delete("DELETE FROM products WHERE id = ?", [$productId]);
        } catch (QueryException $qe) {
            return ["returnType" => 'error', "message" => 'Deletion error: ' . $qe->getMessage()];
        }

        return ["returnType" => 'status', "message" => 'Product was deleted'];
    }
}
