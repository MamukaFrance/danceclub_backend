<?php

namespace App\Exceptions;

use Exception;

class ProfileUpdateException extends Exception
{
    protected $message = 'Impossible de mettre à jour le profil';
}
