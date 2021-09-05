<?php

namespace App\Service\Exception;

use RuntimeException;
use Throwable;

class NothingToChangeException extends RuntimeException
{
    private const DEFAULT_MESSAGE = 'All provided fields have no new values';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ?: self::DEFAULT_MESSAGE;
        parent::__construct($message, $code, $previous);
    }
}