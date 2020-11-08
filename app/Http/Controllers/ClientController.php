<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Http\Requests\Client\StoreClientRequest;
use App\Repository\Client\ClientInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        $clients = $this->client->index();

        return JsonResponder::make($clients);
    }

    public function store(StoreClientRequest $request)
    {
        $client = $this->client->store($request->all());

        return JsonResponder::make($client, true, 201, 'client is created successfully');
    }

    public function show($id)
    {
        $client = $this->client->getById($id);

        return $client ? JsonResponder::make($client) :
            JsonResponder::make(null, false, 404, 'client not found');
    }

    public function update($id, StoreClientRequest $request)
    {
        $client = $this->client->update($id, $request->all());

        return $client ?
            JsonResponder::make($client, true, 202, 'client is updated successfully'):
            JsonResponder::make(null, false, 404, 'client not found');
    }

    public function delete($id)
    {
        $delete = $this->client->delete($id);

        return $delete ?
            JsonResponder::make(null, true, 202, 'client is deleted successfully'):
            JsonResponder::make(null, false, 404, 'client not found');
    }
}
