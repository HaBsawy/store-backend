<?php

namespace App\Repository\Purchase;

use App\Models\Purchase;
use App\Models\PurchaseProduct;

class PurchaseEloquent implements PurchaseInterface
{
    private $purchase;
    private $purchaseProduct;

    public function __construct(Purchase $purchase, PurchaseProduct $purchaseProduct)
    {
        $this->purchase = $purchase;
        $this->purchaseProduct = $purchaseProduct;
    }

    public function index()
    {
        return $this->purchase->with('supplier', 'purchaseProducts', 'products')
            ->where('user_id', auth()->user()->id)->get();
    }

    public function store(array $data)
    {
        $purchase = $this->purchase->create([
            'user_id'       => auth()->user()->id,
            'supplier_id'   => $data['supplier_id'],
            'price'         => $data['price'],
            'paid'          => $data['paid'],
        ]);

        foreach ($data['products'] as $product) {
            if (isset($product['id']) && isset($product['quantity'])) {
                $purchaseProduct = $this->purchaseProduct->create([
                    'purchase_id'   => $purchase->id,
                    'product_id'    => $product['id'],
                    'quantity'      => $product['quantity'],
                ]);

                $pro = $purchaseProduct->product;
                $pro->stock += (int)$product['quantity'];
                $pro->save();
            }
        }

        return $purchase;
    }

    public function getById($purchaseId)
    {
        return $this->purchase->with('supplier')
            ->with(['purchaseProducts' => function($q) {
                $q->with('product')->get();
            }])->find($purchaseId);
    }

    public function update($purchaseId, array $data)
    {
        $purchase = $this->purchase->find($purchaseId);

        if (!$purchase) {
            return false;
        }

        $purchase->supplier_id  = $data['supplier_id'];
        $purchase->price        = $data['price'];
        $purchase->paid         = $data['paid'];
        $purchase->save();

        return $purchase;
    }

    public function destroy($purchaseId)
    {
        $purchase = $this->purchase->find($purchaseId);

        if (!$purchase) {
            return false;
        }

        foreach ($purchase->purchaseProducts as $purchaseProduct) {
            $product = $purchaseProduct->product;
            $product->stock -= $purchaseProduct->quantity;
            $product->save();

            $purchaseProduct->delete();
        }

        $purchase->delete();
        return true;
    }
}
