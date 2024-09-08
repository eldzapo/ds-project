<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\JsonResponse;
use Google_Service_Exception;
use App\Models\Event;

class GoogleCalendarController extends Controller
{
    private $client;
    private $service;
    private $calendarId;

    public function __construct()
    {
        $this->client = $this->createGoogleClient();
        $this->service = new Google_Service_Calendar($this->client);
        $this->calendarId = '2c4f034ddc4abc96291f0f8f883ca7a6a76c284064ef15fc922ebc280708854e@group.calendar.google.com';
    }

    private function createGoogleClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setAuthConfig(base_path('auth.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        return $client;
    }

    private function fetchGoogleCalendarEvents(): array
    {
        try {
            $events = $this->service->events->listEvents($this->calendarId, [
                'maxResults' => 100,
                'singleEvents' => true,
                'orderBy' => 'startTime',
            ]);

            return $events->getItems();
        } catch (Google_Service_Exception $e) {
            throw new \RuntimeException('Google Service Exception: ' . $e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            throw new \RuntimeException('General Exception: ' . $e->getMessage(), 500);
        }
    }

    public function fetchEvents(): JsonResponse
    {
        try {
            $events = $this->fetchGoogleCalendarEvents();
            return response()->json(['events' => $events]);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function syncEvents(): JsonResponse
    {
        try {
            $googleEvents = $this->fetchGoogleCalendarEvents();
            $googleEventIds = array_map(fn($event) => $event->getId(), $googleEvents);

            $existingEventIds = Event::whereIn('google_event_id', $googleEventIds)
                                     ->pluck('google_event_id')
                                     ->toArray();
            $newEvents = array_filter($googleEvents, fn($event) => !in_array($event->getId(), $existingEventIds));

            foreach ($newEvents as $event) {
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
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function syncAndFetchEvents(): JsonResponse
    {
        $syncResponse = $this->syncEvents();

        if ($syncResponse->status() !== 200) {
            return $syncResponse;
        }

        $events = Event::all();

        return response()->json([
            'message' => 'Events synchronized and fetched successfully',
            'events' => $events
        ]);
    }
}
