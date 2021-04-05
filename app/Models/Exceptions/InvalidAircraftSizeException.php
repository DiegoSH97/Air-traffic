<?php

namespace App\Models\Exceptions;

use Exception;

class InvalidAircraftSizeException extends Exception
{
    public function get_message()
    {
        return 'Invalid aircraft size';
    }
}
