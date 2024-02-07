<?php

namespace App\Exceptions;

use Exception;

class PositiveValueException extends Exception
{
    protected $statusCode;

    public function __construct($message, $code = 422, Exception $previous = null)
    {
        $this->statusCode = $code;
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
