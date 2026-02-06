<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-events', function() {
    $allEvents = \App\Models\Event::withoutGlobalScopes()->get();
    $normalEvents = \App\Models\Event::all();

    return response()->json([
        'total_without_scopes' => $allEvents->count(),
        'total_with_scopes' => $normalEvents->count(),
        'events_without_scopes' => $allEvents,
        'events_with_scopes' => $normalEvents,
    ]);
});
