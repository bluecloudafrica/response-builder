<?php

namespace Bluecloud\ResponseBuilder\Exceptions;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseException extends Exception
{
    public function __construct($message = "", $code = 500)
    {
        parent::__construct($message, $code);
    }

    public function render()
    {
        throw new HttpResponseException(response()->json([
            "message" => $this->message,
            "errors" => null,
            "data" => null
        ], $this->code));
    }
}
