<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncGoogleCalendarEvents extends Command
{
    protected $signature = 'sync:google-calendar-events';
    protected $description = 'Sync Google Calendar events daily at midnight';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $response = Http::post('http://your-laravel-app-url/api/sync-events');

        if ($response->successful()) {
            $this->info('Events synchronized successfully.');
        } else {
            $this->error('Failed to synchronize events.');
        }
    }
}
