<?php

namespace App\DTOs;

class BaseDTO
{
    public static function fromArray(array $data): static
    {
        return new static(...$data);
    }
}