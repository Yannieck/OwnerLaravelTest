<?php

namespace App\Http\Controllers;

use App\Product;
use App\Service\Product\ProductService;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return view('products.index');
    }

    public function new(Request $request)
    {
        if (empty($request->name)) {
            return redirect('/products')->with('error', 'Invalid product: No name specified');
        } elseif (empty($request->description)) {
            return redirect('/products')->with('error', 'Invalid product: No description specified');
        }

        $result = $this->productService->new($request->name, $request->description);

        return redirect('/products')->with($result['returnType'], $result['message']);

    }

    public function delete(Request $request)
    {
        if (empty($request->productId) || !is_numeric($request->productId) || $request->productId < 0) {
            return redirect('/products')->with('error', 'Deletion error: invalid product id');
        }

        $result = $this->productService->delete($request->productId);

        return redirect('/products')->with($result['returnType'], $result['message']);
    }
}
