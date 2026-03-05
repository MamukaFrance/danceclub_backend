<?php

namespace App\Exceptions;

use Exception;

class CourseException extends Exception
{
    protected $message = 'Impossible de créer le cours';
}
