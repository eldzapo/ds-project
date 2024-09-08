<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator; 

class EventsController extends Controller
{
    public function getEvents()
    {
        $events = Event::all();

        $data = [
            'status' => 200,
            'events' => $events
        ];
        return response()->json($data, 200);
    }

    public function storeEvent(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'google_event_id' => 'nullable|string|max:255|unique:events,google_event_id',
        ]);
    
        if ($validator->fails()) {
            $data = [
                "status" => 422,
                "errors" => $validator->messages()
            ];
            return response()->json($data, 422);
        }
    
        $event = new Event();
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->location = $request->input('location');
        $event->start_time = $request->input('start_time');
        $event->end_time = $request->input('end_time');
        $event->google_event_id = $request->input('google_event_id');
        $event->save();
    
        $data = [
            'status' => 200,
            'message' => 'Event saved successfully',
            'event' => $event
        ];
    
        return response()->json($data, 200);
    }    
    
}
