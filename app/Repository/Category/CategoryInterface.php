<?php


namespace App\Repository\Category;


interface CategoryInterface
{
    public function index();
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
}
