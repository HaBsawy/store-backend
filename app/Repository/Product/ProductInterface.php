<?php


namespace App\Repository\Product;


interface ProductInterface
{
    public function index();
    public function store(array $data);
    public function show($id);
    public function update($id, array $data);
    public function delete($id);
}
