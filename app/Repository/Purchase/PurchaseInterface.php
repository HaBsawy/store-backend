<?php

namespace App\Repository\Purchase;

interface PurchaseInterface
{
    public function index();
    public function store(array $data);
    public function getById($purchaseId);
    public function update($purchaseId, array $data);
    public function destroy($purchaseId);
}
