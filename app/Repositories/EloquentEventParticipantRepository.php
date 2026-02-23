<?php

namespace App\Repositories;

use App\Models\EventParticipant;
use App\Repositories\Contracts\EventParticipantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class EloquentEventParticipantRepository implements EventParticipantRepositoryInterface
{

    public function __construct(
        protected EventParticipant $model
    ) {}

    /**
    * @return Collection<int, EventParticipant>
    */
     public function all() : Collection
    {
        return $this->model
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function paginate(int $perPage = 10, string $orderBy = 'created_at'): LengthAwarePaginator
    {
        return $this->model
            ->orderBy($orderBy, 'desc')
            ->paginate($perPage);
    }

    public function find(int $id): ?EventParticipant
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): EventParticipant
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): EventParticipant
    {
        return $this->model->create($data);
    }

     public function update(EventParticipant $eventParticipant, array $data): EventParticipant
    {
        $eventParticipant->update($data);
        return $eventParticipant->refresh();
    }

     public function delete(EventParticipant $eventParticipant): bool
    {
        return (bool) $eventParticipant->delete();
    }


    public function findByEventAndUser(int $eventId, int $userId): ?EventParticipant
    {
        return $this->model
            ->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->first();
    }


}
