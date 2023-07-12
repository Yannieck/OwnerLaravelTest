<?php

namespace App\Service\Product;

use App\Product;
use App\Tags;
use Illuminate\Database\QueryException;

class ProductService
{
    public function new(string $name, string $description, array $tags): array
    {
        try {
            $product = Product::create([
                'name' => $name,
                'description' => $description
            ]);
            foreach ($tags as $tagName) {
                $tag = Tags::firstOrCreate([
                    'name' => $tagName,
                ]);
                $product->tags()->attach($tag->id);
            }
        } catch (QueryException $qe) {
            $errorMsg = "";
            switch ($qe->getCode()) {
                case 22001:
                    $errorMsg = "Name is too long (max 64 characters)";
                    break;
                case 23000:
                    $errorMsg = "Product name must be unique";
                    break;
                default:
                    $errorMsg = "Unknown error, code: " . $qe->getMessage();
                    break;
            }

            return ["returnType" => 'error', "message" => 'Invalid product: ' . $errorMsg];
        }

        return ["returnType" => 'status', "message" => 'Product saved'];
    }

    public function delete(int $productId): array
    {
        try {
            Product::destroy($productId);
        } catch (QueryException $qe) {
            return ["returnType" => 'error', "message" => 'Deletion error: ' . $qe->getMessage()];
        }

        return ["returnType" => 'status', "message" => 'Product was deleted'];
    }
}
