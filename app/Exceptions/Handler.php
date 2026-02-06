<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (ProfileUpdateException $e, $request) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        });

        $this->renderable(function (PostException $e, $request) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        });
    }
}
