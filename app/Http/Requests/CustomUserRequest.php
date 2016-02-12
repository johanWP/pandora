<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Este Request se usa UNICAMENTE  para la creación de usuarios nuevos.
 * Para el Update, ver CustomUpdateUsersRequest
 *
 * Class CustomUserRequest
 * @package App\Http\Requests
 */
class CustomUserRequest extends Request
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
            //
            'username'  => 'required|min:3|max:255|unique:users',
            'firstName'  => 'required|min:3|max:255',
            'lastName'  => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'securityLevel' => 'required|numeric'
        ];
    }
}
