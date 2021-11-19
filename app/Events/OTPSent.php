<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;

class OTPSent extends Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(User $user)
    {

        $this->user = $user;
    }
}
