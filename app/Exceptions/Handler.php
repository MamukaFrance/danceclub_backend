<?php

namespace App\Exceptions;

use App\Exceptions\ProfileUpdateException;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof ProfileUpdateException) {
            return back()->with('error', $e->getMessage());
        }

        return parent::render($request, $e);
    }
}
