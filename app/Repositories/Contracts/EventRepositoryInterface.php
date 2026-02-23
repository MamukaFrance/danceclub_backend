<?php

namespace App\Repositories\Contracts;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface EventRepositoryInterface
{
    public function all() : Collection;

    public function paginate(int $perPage, string $orderBy): LengthAwarePaginator;

    public function find(int $id): ?Event;

    public function findOrFail(int $id): Event;

    public function create(array $data): Event;

    public function update(Event $event, array $data): Event;

    public function delete(Event $event): bool;

}
