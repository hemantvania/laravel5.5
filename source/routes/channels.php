<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/*Broadcast::channel('class-channel-{classId}', function ($user, $classId) {
    $usersClassid = \App\UsersClasses::where('class_id','=',$classId)
        ->where('user_id','=',$user->id)
        ->whereDate('class_materials.created_at', '=', date('Y-m-d'))
        ->pluck('user_id');

    return $user->id === $usersClassid;
});*/