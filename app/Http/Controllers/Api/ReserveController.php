<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReserveController extends Controller
{
    public function index()
    {
        return response()->json(Reservation::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'status' => 'required|string',
        ]);

        $reserve = Reservation::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($reserve, 201);
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return response()->json($reservation);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $validated = $request->validate([
            'date' => 'sometimes|date',
            'status' => 'sometimes|string',
        ]);

        $reserve->update($validated);

        return response()->json($reserve);
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();

        return response()->json(null, 204);
    }

    public function myReservations(Request $request)
    {
        $reservations = Reserve::where('user_id', $request->user()->id)->get();
        return response()->json($reservations);
    }
}
