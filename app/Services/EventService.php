<?php

namespace App\Services;

use App\Repositories\Contracts\EventRepositoryInterface;
use App\Models\Event;
use App\Exceptions\EventException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class EventService
{
    public function __construct(
        protected EventRepositoryInterface $eventRepository
    ) {}

    public function getAllEvents(){
        return $this->eventRepository->all();
    }

    public function find(int $id): Event
    {
        $model = $this->eventRepository->find($id);
        if (!$model) {
            throw new EventException('Event introuvable.', 404);
        }
        return $model;
    }

    public function create(array $data): Event
    {      
        $data['user_id'] = auth()->user()->id;
        try {
            return DB::transaction(fn () =>
                $this->eventRepository->create($data)
            );
        } catch (QueryException $e) {
            throw new EventException(
                'Erreur lors de la création du Event.',
                500,
                $e
            );
        } 
    }

    public function update(Event $event, array $data): Event
    {
        try {
            return DB::transaction(fn () =>
                $this->eventRepository->update($event, $data)
            );
        } catch (QueryException $e) {
            throw new EventException(
                'Erreur lors de la mise à jour du Event.',
                500,
                $e
            );
        }
    }

    public function delete(Event $event): bool
    {
        try {
            return DB::transaction(fn () =>
                $this->eventRepository->delete($event)
            );
        } catch (QueryException $e) {
            throw new EventException(
                'Erreur lors de la suppression du Event.',
                500,
                $e
            );
        }
    }
    
}

