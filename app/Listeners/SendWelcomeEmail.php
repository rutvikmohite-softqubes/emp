<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcomeMail;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;
        $password = $event->password;

        try {
            Mail::to($user->email)->queue(new UserWelcomeMail($user, $password));
        } catch (\Exception $e) {
            // Log the error but don't stop the user creation process
            \Log::error('Failed to send welcome email to user: ' . $user->email, [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
        }
    }
}
