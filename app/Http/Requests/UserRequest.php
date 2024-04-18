<?php

namespace App\Http\Requests;

use App\Http\Requests\Base\MyBaseRequest;

class UserRequest extends MyBaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required:string',
            'email' => ['required', 'email'],
            'password' => 'required:string',
        ];
    }
}
