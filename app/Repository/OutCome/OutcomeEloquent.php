<?php


namespace App\Repository\OutCome;


use App\Models\Outcome;

class OutcomeEloquent implements OutcomeInterface
{
    private $outcome;

    public function __construct(Outcome $outcome)
    {
        $this->outcome = $outcome;
    }

    public function store(array $data)
    {
        return $this->outcome->create([
            'user_id'       => auth()->user()->id,
            'supplier_id'   => $data['supplier_id'],
            'price'         => $data['price'],
        ]);
    }

    public function delete($outcomeId)
    {
        $outcome = $this->outcome->where('user_id', auth()->user()->id)
            ->where('id', $outcomeId)->first();

        if(!$outcome) {
            return false;
        }

        $outcome->delete();
        return true;
    }
}
