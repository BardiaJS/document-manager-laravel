<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('chat.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });



Broadcast::routes([
    'middleware' => ['auth:sanctum'],
]);

Broadcast::channel('chat.{id}', function ($user, $id) {
    dd($user, $id);
});
