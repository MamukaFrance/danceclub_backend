<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;

use App\Models\Event;
use App\Exceptions\EventException;

    class EventController extends Controller
    {
        public function __construct(protected EventService $eventService)
        {
            // $this->middleware('role:admin|editor')->only(['create', 'store', 'edit', 'update']);
            $this->authorizeResource(Event::class, 'event');
        }

        // Liste des events
        public function index()
        {
            $events = $this->eventService->getAllEvents();
            return view('web.pages.events.index', compact('events'));
        }

        // Page pour créer un nouveau event
        public function create()
        {
            return view('web.pages.events.create');
        }

        // Sauvegarde d'un nouveau event
        public function store(EventRequest $request)
        {
            try {
                $data = $request->validated();
                $this->eventService->create($data);
                return redirect()
                    ->route('events.index')
                    ->with('success', 'Event ajouté avec succès');
            } catch (EventException $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        // Page pour afficher un event
        public function show(Event $event)
        {
            return view('web.pages.events.show', compact('event'));
        }


        // Page pour éditer un event existant
        public function edit(Event $event)
        {
            return view('web.pages.events.edit', compact('event'));
        }

        // Mise à jour d'un event existant
        public function update(EventRequest $request, Event $event)
        {
            try {
                $data = $request->validated();
                $event->fill($data);
                if (! $event->isDirty()) {
                    return redirect()
                        ->route('events.index')
                        ->with('info', 'Aucune modification détectée');
                }
                $event = $this->eventService->update($event, $data);

                return redirect()
                    ->route('events.index')
                    ->with('success', 'Event mis à jour avec succès');
            } catch (EventException $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            } 
        }

        // Supprimer un event
        public function destroy(Event $event)
        {
            try{
                $this->eventService->delete($event);
                return redirect()
                    ->route('events.index')
                    ->with('success', 'Event supprimé avec succès');;
            }catch (EventException $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

    }

