<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Repository\OutCome\OutcomeInterface;
use Illuminate\Http\Request;

class OutcomeController extends Controller
{
    private $outcome;

    public function __construct(OutcomeInterface $outcome)
    {
        $this->outcome = $outcome;
    }

    public function store(Request $request)
    {
        $outcome = $this->outcome->store($request->all());

        return JsonResponder::make($outcome, true, 201, 'outcome is created successfully');
    }

    public function delete($id)
    {
        $response = $this->outcome->delete($id);

        return $response ? JsonResponder::make(null, true, 202, 'outcome is deleted successfully'):
            JsonResponder::make('null', false, 404, 'outcome not found');
    }
}
