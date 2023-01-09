<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class InitializationException extends BaseException
{
    public int $httpStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
}
