<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        if (!$user->is_admin) {
            return response()->json([
                "message" => "This task is not authorized",
            ], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255|unique:events',
            'description' => 'required|string|max:255',
            'datetime' => 'required|date',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'datetime' => $request->datetime,
            'location' => $request->location,
            'category' => $request->category,
            'capacity' => $request->capacity,
        ]);

        return response()->json([
            "message" => "Event created successfully",
            "event" => $event
        ], 201);
    }

    
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

   
    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    
    public function update(Request $request, $id)
    {
        $user = $request->user();
        if (!$user->is_admin) {
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'datetime' => 'sometimes|date',
            'location' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:100',
        ]);

        $event->update($validated);

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event
        ]);
    }

    
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        if (!$user->is_admin) {
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
