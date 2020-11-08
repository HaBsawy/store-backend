<?php


namespace App\Repository\Income;


interface IncomeInterface
{
    public function store(array $data);
    public function delete($incomeId);
}
