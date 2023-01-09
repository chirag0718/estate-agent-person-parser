<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
abstract class BaseException extends \Exception
{
    protected int $httpStatusCode = 500;

    /**
     * @return JsonResponse
     *
     * @see \Illuminate\Foundation\Exceptions\Handler::convertExceptionToArray()
     */
    public function render(): JsonResponse
    {
        $payload = config('app.debug') ? [
            'message'   => $this->getMessage(),
            'exception' => get_class($this),
            'file'      => $this->getFile(),
            'line'      => $this->getLine(),
            'trace'     => collect($this->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
            'message' => $this->getMessage(),
        ];

        return new JsonResponse(
            $payload,
            $this->httpStatusCode,
            [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }
}
