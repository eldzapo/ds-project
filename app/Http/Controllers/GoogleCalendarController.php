<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\JsonResponse;
use Google_Service_Exception;
use App\Jobs\SyncGoogleCalendarEvents; // Ensure this line is correct
use App\Models\Event; // Import the Event model



class GoogleCalendarController extends Controller
{
    public function fetchEvents(): JsonResponse
    {
        $client = new Google_Client();
        $client->setAuthConfig(base_path('auth.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        $service = new Google_Service_Calendar($client);
        $calendarId = '2c4f034ddc4abc96291f0f8f883ca7a6a76c284064ef15fc922ebc280708854e@group.calendar.google.com'; 

        try {
            $events = $service->events->listEvents($calendarId, [
                'maxResults' => 100, 
                'singleEvents' => true,
                'orderBy' => 'startTime',
            ]);

            return response()->json(['events' => $events->getItems()]);
        } catch (Google_Service_Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function syncEvents(): JsonResponse
{
    $client = new Google_Client();
    $client->setAuthConfig(base_path('auth.json'));
    $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

    $service = new Google_Service_Calendar($client);
    $calendarId = '2c4f034ddc4abc96291f0f8f883ca7a6a76c284064ef15fc922ebc280708854e@group.calendar.google.com';

    try {
        $events = $service->events->listEvents($calendarId, [
            'maxResults' => 100,
            'singleEvents' => true,
            'orderBy' => 'startTime',
        ]);

        $googleEvents = $events->getItems();
        $googleEventIds = array_map(fn($event) => $event->getId(), $googleEvents);

        $existingEventIds = Event::whereIn('google_event_id', $googleEventIds)->pluck('google_event_id')->toArray();
        $newEvents = array_filter($googleEvents, fn($event) => !in_array($event->getId(), $existingEventIds));

        foreach ($newEvents as $event) {
            // Ensure non-null values for the title and other fields
            Event::create([
                'google_event_id' => $event->getId(),
                'title' => $event->getSummary() ?? 'No title provided',
                'description' => $event->getDescription() ?? 'No description available',
                'location' => $event->getLocation() ?? 'No location provided',
                'start_time' => $event->getStart()->getDateTime(),
                'end_time' => $event->getEnd()->getDateTime(),
            ]);
        }

        return response()->json(['message' => 'Events synchronized successfully']);
    } catch (Google_Service_Exception $e) {
        return response()->json(['error' => $e->getMessage()], $e->getCode());
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
