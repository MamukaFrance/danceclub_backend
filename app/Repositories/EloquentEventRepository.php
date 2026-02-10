<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Contracts\EventRepositoryInterface;

class EloquentEventRepository implements EventRepositoryInterface
{
     public function all()
    {
        return Event::orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): ?Event
    {
        return Event::find($id);
    }

    public function create(array $data): Event
    {
        return Event::create($data);
    }

     public function update(Event $event, array $data): Event
    {
        $event->update($data);
        return $event;
    }

     public function delete(Event $event): bool
    {
        return $event->delete();
    }
}
