<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class StoreFailedException extends BaseException
{
    public int $httpStatusCode = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
}
