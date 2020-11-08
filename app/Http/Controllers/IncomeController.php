<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Repository\Income\IncomeInterface;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    private $income;

    public function __construct(IncomeInterface $income)
    {
        $this->income = $income;
    }

    public function store(Request $request)
    {
        $income = $this->income->store($request->all());

        return JsonResponder::make($income, true, 201, 'income is created successfully');
    }

    public function delete($id)
    {
        $response = $this->income->delete($id);

        return $response ? JsonResponder::make(null, true, 202, 'income is deleted successfully'):
            JsonResponder::make('null', false, 404, 'income not found');
    }
}
