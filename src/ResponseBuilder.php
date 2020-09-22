<?php


namespace Bluecloud\ResponseBuilder;


use Illuminate\Http\JsonResponse;

class ResponseBuilder
{
    private $message = "";
    private $status = 200;
    private $errors = [];
    private $key = "data";
    private $data = [];

    public function message(string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function status(int $status)
    {
        $this->status = $status >= 100 && $status < 512 ? $status : 500;
        return $this;
    }

    public function key(string $key)
    {
        $this->key = $key;
        return $this;
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function toJson(): JsonResponse
    {
        return $this->build();
    }

    public function json(): JsonResponse
    {
        return $this->build();
    }
    
    public function build(): JsonResponse
    {
        return response()->json([
            "message" => $this->message,
            "errors" => sizeof($this->errors) == 0 ? null : $this->errors,
            $this->key => sizeof($this->data) == 0 ? null : $this->data
        ], $this->status);
    }

    public function errors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }


    /*
     * Helper Methods
     * */
    public function created(array $data)
    {
        $this->status = 201;
        $this->data = $data;
        $this->message = "resource created";
        return $this;
    }

    public function ok(array $data = [])
    {
        $this->status = 200;
        $this->data = $data;
        $this->message = "request successful";
        return $this;
    }

    public function accepted(array $data = [])
    {
        $this->status = 202;
        $this->data = $data;
        $this->message = "request accepted and processing";
        return $this;
    }

    public function failed($message)
    {
        $this->status = 500;
        $this->message = $message;
        return $this;
    }

    public function unauthenticated($message = "Unauthenticated")
    {
        $this->status = 401;
        $this->message = $message;
        return $this;
    }

    //unauthorized
    public function unauthorized($message = "Forbidden")
    {
        $this->status = 403;
        $this->message = $message;
        return $this;
    }

    public function notFound($message = "resource not found")
    {
        $this->status = 404;
        $this->message = $message;
        return $this;
    }

    public function badRequest($message = "bad request")
    {
        $this->status = 400;
        $this->message = $message;
        return $this;
    }

    public function unprocessable($message = "Failed to process request")
    {
        $this->status = 422;
        $this->message = $message;
        return $this;
    }
}
