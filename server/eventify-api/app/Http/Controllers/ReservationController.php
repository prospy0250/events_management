<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function book(Request $request, $id)
    {
        $request->validate([
            "nb_places" => "required|integer|min:1",
        ]);

        $user = $request->user();
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                "message" => "This event does not exist",
            ], 404);
        }

        // total number of reserved places
        $totalReserved = Reservation::where('event_id', $event->id)->sum('nb_places');

        // checking the capacity if we add the number of places for the current reservation
        if ($totalReserved + $request->nb_places > $event->capacity) {
            return response()->json([
                "message" => "Not enough available seats. Only " . ($event->capacity - $totalReserved) . " remaining.",
            ], 400);
        }

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'nb_places' => $request->nb_places,
        ]);

        return response()->json([
            "message" => "Reservation done successfully",
            "reservation" => $reservation
        ], 201);
    }

public function myReservations(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'User not authentified'], 401);
    }

    $reservations = $user->reservations()->with('event')->get();

    if ($reservations->isEmpty()) {
        return response()->json(['message' => 'No reservations found']);
    }

    return response()->json([
        'user' => $user->username,
        'reservations' => $reservations
    ]);
}

public function cancel(Request $request, $id){
    $user = $request->user();
    $reservation = Reservation::find($id);
    if(!$reservation){
        return response()->json([
            "message" => "The reservation you want to cancel doesn't exists "
        ], 404);
    }
    if($reservation->user->id != $user->id){
        return response()->json([
            "message" => "This operation is not authorized because you don't own this reservation "
        ], 403);
    }

    $reservation->delete();
    return response()->json([
            "message" => "Reservation deleted successfully "
        ]);
}

public function getReservationsByEvent(Request $request, $id){
    $user = $request->user();
    if(!$user->is_admin){
        return response()->json([
            "message" => "This action is not authorized"
        ], 403);
    }

    $event = Event::findOrFail($id);
    $reservations = $event->reservations()->with('user')->get();
    if($reservations->isEmpty()){
        return response()->json([
            "message" => "No reservations for this event"
        ], 404);
    }
    return response()->json([
            "event title" => $event->title,
            "reservations" => $reservations
        ]);
}
}


