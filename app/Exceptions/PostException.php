<?php

namespace App\Exceptions;

use Exception;

class PostException extends Exception
{
    protected $message = 'Impossible de créer le post';
}
