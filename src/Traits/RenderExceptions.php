<?php


namespace Bluecloud\ResponseBuilder\Traits;


use Bluecloud\ResponseBuilder\ResponseBuilder;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

trait RenderExceptions
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException)
            return (new ResponseBuilder())->notFound()->build();

        $builder = (new ResponseBuilder())->failed($exception->getMessage());

        if ($exception->getCode() >= 200 || $exception->getCode() < 599) $builder->status($exception->getCode());

        if ($exception->getMessage() == "") $builder->message("Error while processing your request");

        if ($exception instanceof AuthenticationException) $builder->status(Response::HTTP_UNAUTHORIZED);

        return $builder->build();
    }
}
