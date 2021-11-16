<?php

namespace App\Listeners;



use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;

/**
 *
 */
class AutoVerifyEmails
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Registered $event
     *
     * @return void
     */
    public function handle(Registered $event)
    {
          $user = $event->user;
         $user->update(['email_verified_at' =>Carbon::now()]);
    }
}
