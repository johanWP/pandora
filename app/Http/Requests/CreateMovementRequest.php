<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateMovementRequest extends Request
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
            'quantity1'      => 'required|numeric|min:1',
            'remito'        => 'alpha_num',
            'serial'        => 'alpha_num',
            'origin_id'     => 'required|numeric',
            'destination_id'=> 'required|numeric',
            'article_id1'    => 'required|numeric',
            'ticket'        => 'alpha_num'

        ];
    }
}
