<?php

namespace App\Repositories\Contracts;

use App\Models\EventParticipant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface EventParticipantRepositoryInterface
{
    public function all() : Collection;

    public function paginate(int $perPage, string $orderBy): LengthAwarePaginator;

    public function find(int $id): ?EventParticipant;

    public function findOrFail(int $id): EventParticipant;

    public function create(array $data): EventParticipant;

    public function update(EventParticipant $eventParticipant, array $data): EventParticipant;

    public function delete(EventParticipant $eventParticipant): bool;

    public function findByEventAndUser(int $eventId, int $userId): ?EventParticipant;

}
