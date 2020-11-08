<?php

namespace App\Repository\Sale;

use App\Helper\Twilio;
use App\Models\Sale;
use App\Models\SaleProduct;

class SaleEloquent implements SaleInterface
{
    private $sale;
    private $saleProduct;

    public function __construct(Sale $sale, SaleProduct $saleProduct)
    {
        $this->sale = $sale;
        $this->saleProduct = $saleProduct;
    }

    public function index()
    {
        return $this->sale->with('client', 'saleProducts', 'products')
            ->where('user_id', auth()->user()->id)->get();
    }

    public function store(array $data)
    {
        $sale = $this->sale->create([
            'user_id'   => auth()->user()->id,
            'client_id' => $data['client_id'],
            'price'     => $data['price'],
            'discount'  => $data['discount'],
            'paid'      => $data['paid'],
        ]);

        foreach ($data['products'] as $product) {
            if (isset($product['id']) && isset($product['quantity'])) {
                $saleProduct = $this->saleProduct->create([
                    'sale_id'       => $sale->id,
                    'product_id'    => $product['id'],
                    'quantity'      => $product['quantity'],
                ]);

                $pro = $saleProduct->product;
                $pro->stock -= (int)$product['quantity'];
                $pro->save();

//                if ($pro->stock <= $pro->min_allowed_stock && auth()->user()->mobile) {
//                    $message = 'Product ' . $pro->name .
//                        ' is less than the minimum allowed quantity in the stock -> ' . $pro->stock;
//                    Twilio::send(auth()->user()->mobile, $message);
//                }
            }
        }

        return $sale;
    }

    public function getById($saleId)
    {
        return $this->sale->with('client')
            ->with(['saleProducts' => function($q) {
                $q->with('product')->get();
            }])->find($saleId);
    }

    public function update($saleId, array $data)
    {
        $sale = $this->sale->find($saleId);

        if (!$sale) {
            return false;
        }

        $sale->client_id    = $data['client_id'];
        $sale->price        = $data['price'];
        $sale->discount     = $data['discount'];
        $sale->paid         = $data['paid'];
        $sale->save();

        return $sale;
    }

    public function destroy($saleId)
    {
        $sale = $this->sale->find($saleId);

        if (!$sale) {
            return false;
        }

        foreach ($sale->saleProducts as $saleProduct) {
            $product = $saleProduct->product;
            $product->stock += $saleProduct->quantity;
            $product->save();

            $saleProduct->delete();
        }

        $sale->delete();
        return true;
    }
}
