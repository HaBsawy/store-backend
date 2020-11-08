<?php


namespace App\Repository\OutCome;


interface OutcomeInterface
{
    public function store(array $data);
    public function delete($outcomeId);
}
