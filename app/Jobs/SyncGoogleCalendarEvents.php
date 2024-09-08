<?php

namespace App\Jobs;

use Google_Client;
use Google_Service_Calendar;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncGoogleCalendarEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $client = new Google_Client();
        $client->setAuthConfig(base_path('auth.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        $service = new Google_Service_Calendar($client);
        $calendarId = '2c4f034ddc4abc96291f0f8f883ca7a6a76c284064ef15fc922ebc280708854e@group.calendar.google.com';

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
            Event::create([
                'google_event_id' => $event->getId(),
                'title' => $event->getSummary(),
                'description' => $event->getDescription() ?? 'No description available',
                'location' => $event->getLocation() ?? 'No location provided',
                'start_time' => $event->getStart()->getDateTime(),
                'end_time' => $event->getEnd()->getDateTime(),
            ]);
        }
    }
}
