<?php

namespace Bluecloud\ResponseBuilder\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

abstract class BaseFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "message" => "Validation failed",
            "errors" => collect($this->validator->getMessageBag()),
            "data" => null
        ], Response::HTTP_BAD_REQUEST));
    }
}
