<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Http\Requests\Sale\StoreSaleRequest;
use App\Repository\Sale\SaleInterface;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    private $sale;

    public function __construct(SaleInterface $sale)
    {
        $this->sale = $sale;
    }

    public function index()
    {
        $sales = $this->sale->index();

        return JsonResponder::make($sales);
    }

    public function store(StoreSaleRequest $request)
    {
        $sale = $this->sale->store($request->all());

        return JsonResponder::
        make($sale, true, 201, 'Sale is created successfully');
    }

    public function show($id)
    {
        $sale = $this->sale->getById($id);

        return $sale ? JsonResponder::make($sale) :
            JsonResponder::make(null, false, 404, 'sale not found');
    }

    public function update($id, StoreSaleRequest $request)
    {
        $sale = $this->sale->update($id, $request->all());

        return $sale ?
            JsonResponder::make(null, true, 202, 'Sale is updated successfully'):
            JsonResponder::make(null, false, 404, 'Sale not found');
    }

    public function delete($id)
    {
        $sale = $this->sale->destroy($id);

        return $sale ?
            JsonResponder::make(null, true, 202, 'Sale is deleted successfully'):
            JsonResponder::make(null, false, 404, 'Sale not found');
    }
}
