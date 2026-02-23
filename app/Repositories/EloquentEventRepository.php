<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;



class EloquentEventRepository implements EventRepositoryInterface
{

    public function __construct(
        protected Event $model
    ) {}

    /**
    * @return Collection<int, Event>
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

    public function find(int $id): ?Event
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Event
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Event
    {
        return $this->model->create($data);
    }

     public function update(Event $event, array $data): Event
    {
        $event->update($data);
        return $event->refresh();
    }

     public function delete(Event $event): bool
    {
        return (bool) $event->delete();
    }

}
