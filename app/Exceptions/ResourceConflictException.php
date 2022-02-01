<?php

namespace App\Exceptions;

class ResourceConflictException extends \Exception
{
    public function __construct($message = "Db error", $code = 409)
    {
        parent::__construct($message, $code);
    }
}
