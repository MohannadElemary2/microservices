<?php

namespace App\Observers;

use App\Models\User;
use Carbon\Carbon;
use Junges\Kafka\Facades\Kafka;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $producer = Kafka::publishOn('email-notifications')
            ->withBodyKey("user_id", $user->id)
            ->withBodyKey("date", Carbon::today()->toDateString())
            ->withBodyKey("name", $user->name)
            ->withBodyKey("email", $user->email);

        $producer->send();
    }
}
