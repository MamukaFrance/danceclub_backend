<?php

namespace App\Services;

use App\Repositories\Contracts\EventRepositoryInterface;
use App\Models\Event;

class EventService
{
    public function __construct(
        protected EventRepositoryInterface $eventRepository
    ) {}

    public function getAllEvents(){
        return $this->eventRepository->all();
    }

    public function find(int $id): ?Event
    {
        return $this->eventRepository->find($id);
    }

    public function create(array $data): Event
    {
        return $this->eventRepository->create($data);
    }

    public function update(Event $event, array $data): Event
    {
        return $this->eventRepository->update($event, $data);
    }

    public function delete(Event $event): bool
    {
        return $this->eventRepository->delete($event);
    }
}

