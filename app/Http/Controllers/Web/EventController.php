<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\EventService;

 use Illuminate\Http\Request;
    use App\Models\Event;

    class EventController extends Controller
    {
        public function __construct(
            protected EventService $eventService
        ) {}

        // Liste des events
        public function index()
        {
            $events = $this->eventService->getAllEvents();
            return view('web.event.index', compact('events'));
        }

        // Page pour créer un nouveau event
        public function create()
        {
            return view('web.event.create');
        }

        // Sauvegarde d'un nouveau event
        public function store(Request $request)
        {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'capacity' => 'required|integer',
            ]);

            $this->eventService->create($data);
            return redirect()->route('event.index');
        }

        // Page pour afficher un event
        public function show(Event $event)
        {
            return view('web.event.show', compact('event'));
        }


        // Page pour éditer un event existant
        public function edit(Event $event)
        {
            return view('web.event.edit', compact('event'));
        }

        // Mise à jour d'un event existant
        public function update(Request $request, Event $event)
        {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'capacity' => 'required|integer',
            ]);

            $this->eventService->update($event, $data);

            return redirect()->route('event.index');
        }

        // Supprimer un event
        public function destroy(Event $event)
        {
            $this->eventService->delete($event);
            return redirect()->route('event.index');
        }
    }

