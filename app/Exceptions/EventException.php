<?php

namespace App\Exceptions;

use Exception;

class EventException extends Exception
{
    public function __construct(
        string $message = 'Une erreur est survenue.',
        int $code = 422,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    public function render($request)
    {
        $status = $this->getCode() ?: 422;
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage()
            ], $status);
        }
        return back()
            ->withInput()
            ->with('error', $this->getMessage());
    }
}
