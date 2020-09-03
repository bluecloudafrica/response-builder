<?php


namespace Bluecloud\ResponseBuilder\Traits;


use Bluecloud\ResponseBuilder\ResponseBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

trait RenderExceptions
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) return (new ResponseBuilder())->notFound()->build();

        $builder = (new ResponseBuilder())->failed($exception->getMessage());

        if ($exception->getCode() >= 200 || $exception->getCode() < 599) $builder->status($exception->getCode());

        return $builder->build();
    }
}
