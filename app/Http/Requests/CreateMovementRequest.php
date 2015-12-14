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
            'quantity'      => 'required|numeric',
            'remito'        => 'numeric',
            'serial'        => 'alpha_num',
            'origin_id'     => 'required',
            'destination_id'=> 'required',
            'article_id'    => 'required',
            'ticket'        => 'required'

        ];
    }
}