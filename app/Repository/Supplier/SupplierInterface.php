<?php


namespace App\Repository\Supplier;


interface SupplierInterface
{
    public function index();
    public function store(array $data);
    public function getById($supplierId);
    public function update($id, array $data);
    public function delete($id);
}
