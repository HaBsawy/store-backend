<?php


namespace App\Repository\Income;


use App\Models\Income;

class IncomeEloquent implements IncomeInterface
{
    private $income;

    public function __construct(Income $income)
    {
        $this->income = $income;
    }

    public function store(array $data)
    {
        return $this->income->create([
            'user_id'   => auth()->user()->id,
            'client_id' => $data['client_id'],
            'price'     => $data['price'],
        ]);
    }

    public function delete($incomeId)
    {
        $income = $this->income->where('user_id', auth()->user()->id)
            ->where('id', $incomeId)->first();

        if(!$income) {
            return false;
        }

        $income->delete();
        return true;
    }
}
