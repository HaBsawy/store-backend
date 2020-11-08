<?php


namespace App\Repository\Product;


use App\Models\Product;

class ProductEloquent implements ProductInterface
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        return $this->product->with('category')->where('user_id', auth()->user()->id)->get();
    }

    public function store(array $data)
    {
        return $this->product->create([
            'user_id'           => auth()->user()->id,
            'category_id'       => $data['category_id'],
            'name'              => $data['name'],
            'description'       => isset($data['description']) ? $data['description'] : null,
            'stock'             => $data['stock'],
            'min_allowed_stock' => $data['min_allowed_stock'],
            'buy_price'         => $data['buy_price'],
            'sell_price'        => $data['sell_price'],
        ]);
    }

    public function show($id)
    {
        $product = $this->product->find($id);

        return $product ? $product : null;
    }

    public function update($id, array $data)
    {
        $product = $this->product->find($id);

        if (!$product) {
            return null;
        }

        $product->category_id       = $data['category_id'];
        $product->name              = $data['name'];
        $product->description       = isset($data['description']) ? $data['description'] : $product->description;
        $product->stock             = $data['stock'];
        $product->min_allowed_stock = $data['min_allowed_stock'];
        $product->buy_price         = $data['buy_price'];
        $product->sell_price        = $data['sell_price'];
        $product->save();

        return $product;
    }

    public function delete($id)
    {
        $product = $this->product->find($id);

        if (!$product) {
            return null;
        }
        return $product->delete() ? true : false;
    }
}
