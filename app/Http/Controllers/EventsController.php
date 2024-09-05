<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    //

    public function getEvents(){

        $events = Event::all();

        $data =  [
            'status' => 200,
            'events' => $events
        ];
        return response()->json($data, 200);
    }

    public function storeEvent(Request $request)
    {
        $event = Event::create($request->only([
            'title',
            'description',
            'location',
            'start_time',
            'end_time',
            'google_event_id'
        ]));

        return response()->json([
            'status' => 201,
            'event' => $event
        ], 201);
    }
}
