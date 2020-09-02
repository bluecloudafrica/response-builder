<?php


namespace Bluecloud\ResponseBuilder\Traits;

use Bluecloud\ResponseBuilder\ResponseBuilder;

trait BuildResponse
{
    public function respond(): ResponseBuilder
    {
        return new ResponseBuilder();
    }
}
