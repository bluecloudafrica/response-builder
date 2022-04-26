<?php


namespace Bluecloud\ResponseBuilder;


use Illuminate\Http\JsonResponse;

class ResponseBuilder
{
    private $message = "";
    private $status = 200;
    private $errors = [];
    private $key = "data";
    private $trace = [];
    private $data = null;

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function status(int $status): self
    {
        $this->status = $status >= 100 && $status < 512 ? $status : 500;
        return $this;
    }

    public function key(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function data($data): self
    {
        $this->data = $data;
        return $this;
    }

    public function trace($trace): self
    {
        $this->trace = $trace;
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
            "errors" => $this->errors,
            "trace" => $this->trace,
            $this->key => $this->data
        ], $this->status);
    }

    public function errors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }


    /*
     * Helper Methods
     * */
    public function created(array $data): self
    {
        $this->status = 201;
        $this->data = $data;
        $this->message = "Resource created";
        return $this;
    }

    public function ok($data = []): self
    {
        $this->status = 200;
        $this->data = $data;
        $this->message = "Completed successfully";
        return $this;
    }

    public function accepted(array $data = []): self
    {
        $this->status = 202;
        $this->data = $data;
        $this->message = "Request accepted and processing";
        return $this;
    }

    public function failed($message): self
    {
        $this->status = 500;
        $this->message = $message;
        return $this;
    }

    public function serviceUnavailable($message = 'The service is unavailable'): self
    {
        $this->status = 503;
        $this->message = $message;
        return $this;
    }

    public function unauthenticated($message = "Unauthenticated"): self
    {
        $this->status = 401;
        $this->message = $message;
        return $this;
    }

    //unauthorized
    public function unauthorized($message = "Forbidden"): self
    {
        $this->status = 403;
        $this->message = $message;
        return $this;
    }

    public function notFound($message = "Resource not found"): self
    {
        $this->status = 404;
        $this->message = $message;
        return $this;
    }

    public function badRequest($message = "Bad request"): self
    {
        $this->status = 400;
        $this->message = $message;
        return $this;
    }

    public function unprocessable($message = "Failed to process request"): self
    {
        $this->status = 422;
        $this->message = $message;
        return $this;
    }

    public function preconditionFailed(string $message = 'Precondition failed'): self
    {
        $this->status = 412;
        $this->message = $message;
        return $this;
    }
}
