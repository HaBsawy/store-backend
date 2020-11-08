<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Repository\Purchase\PurchaseInterface;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    private $purchase;

    public function __construct(PurchaseInterface $purchase)
    {
        $this->purchase = $purchase;
    }

    public function index()
    {
        $purchases = $this->purchase->index();

        return JsonResponder::make($purchases);
    }

    public function store(StorePurchaseRequest $request)
    {
        $purchase = $this->purchase->store($request->all());

        return JsonResponder::
            make($purchase, true, 201, 'Purchase is created successfully');
    }

    public function show($id)
    {
        $purchase = $this->purchase->getById($id);

        return $purchase ? JsonResponder::make($purchase) :
            JsonResponder::make(null, false, 404, 'purchase not found');
    }

    public function update($id, StorePurchaseRequest $request)
    {
        $purchase = $this->purchase->update($id, $request->all());

        return $purchase ?
            JsonResponder::make(null, true, 202, 'Purchase is updated successfully'):
            JsonResponder::make(null, false, 404, 'Purchase not found');
    }

    public function delete($id)
    {
        $purchase = $this->purchase->destroy($id);

        return $purchase ?
            JsonResponder::make(null, true, 202, 'Purchase is deleted successfully'):
            JsonResponder::make(null, false, 404, 'Purchase not found');
    }
}
