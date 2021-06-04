<?php

namespace MonerisAssignment\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * MonerisException to be used as base class for all other exceptions
 */

class MonerisException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        Log::warning("Moneris: (" . $code . ") " . $message);
        parent::__construct($message, $code, $previous);
    }
}
