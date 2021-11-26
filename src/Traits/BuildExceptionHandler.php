<?php


namespace Bluecloud\ResponseBuilder\Traits;

use Bluecloud\ResponseBuilder\ResponseBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

trait BuildExceptionHandler
{
    public function render($request, Throwable $exception): JsonResponse
    {
        if ($exception instanceof ModelNotFoundException) return (new ResponseBuilder())->notFound()->build();

        $builder = (new ResponseBuilder())->failed($exception->getMessage());

        if ($exception->getCode() >= 200 || $exception->getCode() < 599) $builder->status($exception->getCode());

        return $builder->toJson();
    }
}
