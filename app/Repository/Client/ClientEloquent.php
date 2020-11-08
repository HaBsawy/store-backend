<?php


namespace App\Repository\Client;


use App\Models\Client;

class ClientEloquent implements ClientInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        return auth()->user()->clients;
    }

    public function store(array $data)
    {
        return $this->client->create([
            'user_id'   => auth()->user()->id,
            'name'      => $data['name'],
            'mobile'    => $data['mobile'],
        ]);
    }

    public function getById($clientId)
    {
        return $this->client->with('sales', 'incomes')->find($clientId);
    }

    public function update($id, array $data)
    {
        $client = $this->client->find($id);

        if (!$client) {
            return null;
        }

        $client->name     = $data['name'];
        $client->mobile   = $data['mobile'];
        $client->save();

        return $client;
    }

    public function delete($id)
    {
        $client = $this->client->find($id);

        if (!$client) {
            return null;
        }
        return $client->delete() ? true : false;
    }
}
