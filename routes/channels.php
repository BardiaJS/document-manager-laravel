<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes([
    'prefix' => 'api',
    'middleware' => ['auth:sanctum'], // بدون 'auth' => 'api'
]);

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id; // فقط گیرنده اجازه داره وصل بشه
});