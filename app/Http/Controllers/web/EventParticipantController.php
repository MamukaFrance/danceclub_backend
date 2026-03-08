<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\EventParticipantService;
use Illuminate\Http\Request;
use App\Http\Requests\EventParticipantRequest;
use App\Models\EventParticipant;
use App\Exceptions\EventParticipantException;
use App\Models\Event;

    class EventParticipantController extends Controller
    {
        public function __construct(protected EventParticipantService $eventParticipantService)
        {
            $this->authorizeResource(EventParticipant::class, 'eventParticipant');

            $this->middleware('role:admin|editor')->only(['create', 'store', 'edit']);
        }

        // Liste des eventParticipants
        public function index()
        {
            $eventParticipants = $this->eventParticipantService->getAllEventParticipants();
            return view('web.pages.eventparticipants.index', compact('eventParticipants'));
        }

        // Page pour créer un nouveau eventParticipant
        public function create()
        {
            return view('web.pages.eventparticipants.create');
        }

        // Sauvegarde d'un nouveau eventParticipant
        public function store(EventParticipantRequest $request)
        {         
            try {
                $data = $request->validated();
                $data['user_id'] = auth()->user()->id;
                $data['status'] = 'registered';
                $this->eventParticipantService->create($data);
                return redirect()
                    ->route('events.index')
                    ->with('success', 'EventParticipant ajouté avec succès');
            } catch (EventParticipantException $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        // Page pour afficher un eventParticipant
        public function show(EventParticipant $eventParticipant)
        {
            return view('web.pages.eventparticipants.show', compact('eventParticipant'));
        }


        // Page pour éditer un eventParticipant existant
        public function edit(EventParticipant $eventParticipant)
        {
            return view('web.pages.eventparticipants.edit', compact('eventParticipant'));
        }

        // Mise à jour d'un eventParticipant existant
        public function update(EventParticipantRequest $request, EventParticipant $eventParticipant)
        {
            try {
                $data = $request->validated();
                $eventParticipant->fill($data);
                if (! $eventParticipant->isDirty()) {
                    return redirect()
                        ->route('events.index')
                        ->with('info', 'Aucune modification détectée');
                }
                $eventParticipant = $this->eventParticipantService->update($eventParticipant, $data);


                return redirect()
                    ->route('events.index')
                    ->with('success', 'EventParticipant mis à jour avec succès');
            } catch (EventParticipantException $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            } 
        }

        // Supprimer un eventParticipant
        public function destroy(EventParticipant $eventParticipant)
        { 
            try{
                $this->eventParticipantService->delete($eventParticipant);
                return redirect()
                    ->route('events.index')
                    ->with('success', 'EventParticipant supprimé avec succès');;
            }catch (EventParticipantException $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        public function register(Event $event)
        {
            $this->authorize('register', $event);

            $this->eventParticipantService->register($event->id, auth()->id());

            return back()->with('success', 'Inscription réussie.');
        }

        public function cancel(EventParticipant $participant)
        {
            $this->authorize('cancel', $participant);

            $this->eventParticipantService->cancel($participant);

            return back()->with('success', 'Participation annulée.');
        }

        public function checkin($token)
        {
            $participant = EventParticipant::where('token', $token)->firstOrFail();

            if ($participant->present) {
                return back()->with('info', 'Ce participant a déjà été enregistré.');
            }

            $participant->present = true;
            $participant->save();

            return view('events.checkin_success', compact('participant'));        }
    }

