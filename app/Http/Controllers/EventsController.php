<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    //

    public function index(){

        $events = Event::all();

        $data =  [
            'status' => 200,
            'events' => $events
        ];
        return response()->json($data, 200);
    }
}
