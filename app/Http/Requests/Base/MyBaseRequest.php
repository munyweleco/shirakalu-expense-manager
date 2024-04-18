<?php

namespace App\Http\Requests\Base;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class MyBaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

//    protected function failedValidation(Validator $validator): mixed
//    {
//        throw new HttpResponseException(response()->json([
//            'errors' => $validator->errors(),
//        ], 422));
//    }
}
