<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Http\Requests\Product\StoreProductRequest;
use App\Repository\Product\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $products = $this->product->index();

        return JsonResponder::make($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->product->store($request->all());

        return JsonResponder::make($product, true, 201, 'product is created successfully');
    }

    public function show($id)
    {
        $product = $this->product->show($id);

        return $product ?
            JsonResponder::make($product, true, 200, 'product is loaded successfully'):
            JsonResponder::make(null, false, 404, 'product not found');
    }

    public function update($id, StoreProductRequest $request)
    {
        $product = $this->product->update($id, $request->all());

        return $product ?
            JsonResponder::make($product, true, 202, 'product is updated successfully'):
            JsonResponder::make(null, false, 404, 'product not found');
    }

    public function delete($id)
    {
        $delete = $this->product->delete($id);

        return $delete ?
            JsonResponder::make(null, true, 202, 'product is deleted successfully'):
            JsonResponder::make(null, false, 404, 'product not found');
    }
}
