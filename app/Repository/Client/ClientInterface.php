<?php


namespace App\Repository\Client;


interface ClientInterface
{
    public function index();
    public function store(array $data);
    public function getById($clientId);
    public function update($id, array $data);
    public function delete($id);
}
