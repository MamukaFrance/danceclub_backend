<?php

namespace App\Services;

use App\Repositories\Contracts\EventParticipantRepositoryInterface;
use App\Models\EventParticipant;
use App\Exceptions\EventParticipantException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Models\Event;
use App\Enums\EventParticipantStatus;

class EventParticipantService
{
    public function __construct(
        protected EventParticipantRepositoryInterface $eventParticipantRepository
    ) {}

    public function getAllEventParticipants(){
        return $this->eventParticipantRepository->all();
    }

    public function find(int $id): EventParticipant
    {
        $model = $this->eventParticipantRepository->find($id);
        if (!$model) {
            throw new EventParticipantException('EventParticipant introuvable.', 404);
        }
        return $model;
    }

    public function create(array $data): EventParticipant
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->eventParticipantRepository->create($data);
            });
        } catch (QueryException $e) {
            throw new EventParticipantException(
                'Erreur lors de la création du EventParticipant.',
                500,
                $e
            );
        } 
    }

    public function update(EventParticipant $eventParticipant, array $data): EventParticipant
    {
        try {
            return DB::transaction(function () use ($eventParticipant, $data) {
                return $this->eventParticipantRepository->update($eventParticipant, $data);
            });
        } catch (QueryException $e) {
            throw new EventParticipantException(
                'Erreur lors de la mise à jour du EventParticipant.',
                500,
                $e
            );
        }
    }

    public function delete(EventParticipant $eventParticipant): bool
    {
        try {
            return DB::transaction(function () use ($eventParticipant) {
                return $this->eventParticipantRepository->delete($eventParticipant);
            });
        } catch (QueryException $e) {
            throw new EventParticipantException(
                'Erreur lors de la suppression du EventParticipant.',
                500,
                $e
            );
        }
    }

    public function register(int $eventId, int $userId): EventParticipant
    {
        try {
            return DB::transaction(function () use ($eventId, $userId) {
                $exists = $this->eventParticipantRepository
                    ->findByEventAndUser($eventId, $userId);
                if ($exists && $exists->status === EventParticipantStatus::REGISTERED) {
                    throw new EventParticipantException(
                        'Vous participez déjà à cet event.',
                        400
                    );
                }
                $this->ensureEventIsNotFull($eventId);
                if ($exists) {
                    return $this->eventParticipantRepository->update($exists, [
                        'status' => EventParticipantStatus::REGISTERED
                    ]);
                }
                return $this->eventParticipantRepository->create([
                    'event_id' => $eventId,
                    'user_id'  => $userId,
                    'status'   => EventParticipantStatus::REGISTERED
                ]);
            });
        } catch (QueryException $e) {
            throw new EventParticipantException(
                'Une erreur est survenue lors de l\'inscription à l\'event.',
                500,
                $e
            );
        }
    }

    public function cancel(EventParticipant $eventParticipant): EventParticipant
    {
        try {
            return DB::transaction(function () use ($eventParticipant) {
                if ($eventParticipant->status === EventParticipantStatus::CANCELLED) {
                    throw new EventParticipantException(
                        'Participation déjà annulée.',
                        400
                    );
                }
                return $this->eventParticipantRepository->update(
                    $eventParticipant,
                    ['status' => EventParticipantStatus::CANCELLED]
                );
            });
        } catch (QueryException $e) {
            throw new EventParticipantException(
                'Une erreur est survenue lors de l\'annulation de la participation.',
                500,
                $e
            );
        }
    }


    
    private function ensureEventIsNotFull(int $eventId): void
    {
        $event = Event::lockForUpdate()->findOrFail($eventId);
        $registeredCount = $event->eventParticipants()
            ->where('status', EventParticipantStatus::REGISTERED)
            ->count();
        if ($registeredCount >= $event->capacity) {
            throw new EventParticipantException(
                'L\'event est plein.',
                400
            );
        }
    }


}

