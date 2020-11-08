<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|min:3|max:100',
            'description'       => 'nullable|min:3|max:500',
            'stock'             => 'required|numeric|min:0|max:999999',
            'min_allowed_stock' => 'required|numeric|min:0|max:999',
            'buy_price'         => 'required|numeric|min:0|max:1000000',
            'sell_price'        => 'required|numeric|min:0|max:1000000',
        ];
    }
}
