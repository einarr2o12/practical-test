<?php

namespace App\Exceptions;

class ResourceForbiddenException extends \Exception
{
    public function __construct($message = "Invalid credentials", $code = 403)
    {
        parent::__construct($message, $code);
    }
}
