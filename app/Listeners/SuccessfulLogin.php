<?php

namespace App\Listeners;

use Laravel\Passport\Events\AccessTokenCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\User;

class SuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated  $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        $timeDate = new \DateTime();
        if(!empty($event->userId)){
            $user = User::find($event->userId);
            $user->last_login = $timeDate;
            $user->save();
        }

        //var_dump($timeDate);
        // print("TIEMPO ACTUAL "+$timeDate);
        $user->last_login = $timeDate;
        $user->save();
    }
}
