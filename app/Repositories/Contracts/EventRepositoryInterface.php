<?php

namespace App\Repositories\Contracts;

use App\Models\Event;

interface EventRepositoryInterface
{
    public function all();

    public function find(int $id): ?Event;

    public function create(array $data): Event;

    public function update(Event $event, array $data): Event;

    public function delete(Event $event): bool;

}
