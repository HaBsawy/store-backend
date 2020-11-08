<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $incomes = 0;
        $outcomes = 0;
        $creditor = 0;
        $debtor = 0;
        foreach ($user->clients as $client) {
            foreach ($client->sales as $sale) {
                $incomes += $sale->price - $sale->discount;
                $creditor += $sale->price - $sale->discount - $sale->paid;
            }
            foreach ($client->incomes as $income) {
                $creditor -= $income->price;
            }
        }
        foreach ($user->suppliers as $supplier) {
            foreach ($supplier->purchases as $purchase) {
                $outcomes += $purchase->price;
                $debtor += $purchase->price - $purchase->paid;
            }
            foreach ($supplier->outcomes as $outcome) {
                $debtor -= $outcome->price;
            }
        }
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'income' => number_format($incomes, 2, '.', ','),
            'outcome' => number_format($outcomes, 2, '.', ','),
            'creditor' => number_format($creditor, 2, '.', ','),
            'debtor' => number_format($debtor, 2, '.', ','),
            'categories_count' => count($user->categories),
            'suppliers_count' => count($user->suppliers),
            'clients_count' => count($user->clients),
            'products_count' => count($user->products),
            'sales_count' => count($user->sales),
            'purchases_count' => count($user->purchases),
        ];
        return JsonResponder::make($data);
    }
}
