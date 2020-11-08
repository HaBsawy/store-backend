<?php


namespace App\Repository\Sale;


interface SaleInterface
{
    public function index();
    public function store(array $data);
    public function getById($saleId);
    public function update($saleId, array $data);
    public function destroy($saleId);
}
