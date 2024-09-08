<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\JsonResponse;
use Google_Service_Exception;

class GoogleCalendarController extends Controller
{
    public function fetchEvents(): JsonResponse
    {
        $client = new Google_Client();
        $client->setAuthConfig(base_path('auth.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        $service = new Google_Service_Calendar($client);
        $calendarId = '2c4f034ddc4abc96291f0f8f883ca7a6a76c284064ef15fc922ebc280708854e@group.calendar.google.com'; // Use 'primary' or replace with a specific calendar ID if needed

        try {
            $events = $service->events->listEvents($calendarId, [
                'maxResults' => 10, // Adjust the number of results to fetch as needed
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
}
