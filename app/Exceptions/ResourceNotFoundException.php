<?php

namespace App\Exceptions;

class ResourceNotFoundException extends \Exception
{
    public function __construct($message = "Not Found", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
