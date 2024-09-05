<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Event title
            $table->text('description')->nullable(); // Event description
            $table->string('location')->nullable(); // Event location
            $table->datetime('start_time'); // Event start time
            $table->datetime('end_time'); // Event end time
            $table->string('google_event_id')->unique(); // Unique ID from Google Calendar
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
