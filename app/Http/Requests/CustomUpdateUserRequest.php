<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Se usa UNICAMENTE EN EL UPDATE
 * Class CustomUpdateUserRequest
 * @package App\Http\Requests
 */
class CustomUpdateUserRequest extends Request
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
     * Aplica validaciones al update de usuarios
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'firstName'  => 'required|min:3|max:255',
            'lastName'  => 'required|min:3|max:255',
            'email' => 'required|email|max:255',

        ];
    }
}
