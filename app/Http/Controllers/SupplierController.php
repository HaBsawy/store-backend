<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Repository\Supplier\SupplierInterface;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $supplier;

    public function __construct(SupplierInterface $supplier)
    {
        $this->supplier = $supplier;
    }

    public function index()
    {
        $suppliers = $this->supplier->index();

        return JsonResponder::make($suppliers);
    }

    public function store(StoreSupplierRequest $request)
    {
        $supplier = $this->supplier->store($request->all());

        return JsonResponder::make($supplier, true, 201, 'supplier is created successfully');
    }

    public function show($id)
    {
        $supplier = $this->supplier->getById($id);

        return $supplier ? JsonResponder::make($supplier) :
            JsonResponder::make(null, false, 404, 'supplier not found');
    }

    public function update($id, StoreSupplierRequest $request)
    {
        $supplier = $this->supplier->update($id, $request->all());

        return $supplier ?
            JsonResponder::make($supplier, true, 202, 'supplier is updated successfully'):
            JsonResponder::make(null, false, 404, 'supplier not found');
    }

    public function delete($id)
    {
        $delete = $this->supplier->delete($id);

        return $delete ?
            JsonResponder::make(null, true, 202, 'supplier is deleted successfully'):
            JsonResponder::make(null, false, 404, 'supplier not found');
    }
}
