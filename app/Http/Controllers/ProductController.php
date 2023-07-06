<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function new(Request $request)
    {
        if (empty($request->name)) {
            return redirect('/products')->with('error', 'Invalid product: No name specified');
        }

        try {
            DB::insert("INSERT INTO products (name) VALUES (?)", [$request->name]);
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
            return redirect('/products')->with('error', 'Invalid product: ' . $errorMsg);
        }

        return redirect('/products')->with('status', 'Product saved');
    }

    public function delete(Request $request)
    {
        if(!is_numeric($request->productId) || $request->productId < 0) {
            return redirect('/products')->with('error', 'Deletion error: invalid product id');
        }

        try {
            DB::delete("DELETE FROM products WHERE id = ?", [$request->productId]);
        } catch (QueryException $qe) {
            return redirect('/products')->with('error', 'Deletion error: '. $qe->getMessage());
        }

        return redirect('/products')->with('status', 'Product was deleted');
    }
}
