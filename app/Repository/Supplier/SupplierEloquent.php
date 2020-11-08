<?php


namespace App\Repository\Supplier;


use App\Models\Supplier;

class SupplierEloquent implements SupplierInterface
{
    private $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function index()
    {
        return auth()->user()->suppliers;
    }

    public function store(array $data)
    {
        return $this->supplier->create([
            'user_id'   => auth()->user()->id,
            'name'      => $data['name'],
            'mobile'    => $data['mobile'],
        ]);
    }

    public function getById($supplierId)
    {
        return $this->supplier->with('purchases', 'outcomes')->find($supplierId);
    }

    public function update($id, array $data)
    {
        $supplier = $this->supplier->find($id);

        if (!$supplier) {
            return null;
        }

        $supplier->name     = $data['name'];
        $supplier->mobile   = $data['mobile'];
        $supplier->save();

        return $supplier;
    }

    public function delete($id)
    {
        $supplier = $this->supplier->find($id);

        if (!$supplier) {
            return null;
        }
        return $supplier->delete() ? true : false;
    }
}
