<?php

namespace App\Listeners;

use App\Events\UserValidatedViaPhone;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;

/**
 *
 */
class VerifyUserPhone
{
    /**
     * Handle the event.
     *
     * @param UserValidatedViaPhone $event
     *
     * @return void
     */
    public function handle(UserValidatedViaPhone $event)
    {
        $user = $event->user;
        $user->update(['phone_validated_at' => Carbon::now()]);
    }
}
