<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id'   => 'required|exists:suppliers,id',
            'price'         => 'required|numeric|min:0|max:100000000',
            'paid'          => 'required|numeric|min:0|max:100000000',
        ];
    }
}
