<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use Log;

class SendWelcomeEmail
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $data = array('name' => $event->newuser['name'], 'email' => $event->newuser['email']);
        try {
            if (!empty($data['email'])) {
                Mail::send(['text' => 'mail'], $data, function ($message) use ($data) {
                    $message->to($data['email'])->subject
                    ('Laravel Basic Testing Mail');
                    $message->from('noreplay@mobiosolution.com');
                });
                echo "This is Email Sent to log. Check your log file.";
            }
        } catch (\Exception $e) {
            Log::info('Error' . $e->getMessage());
        }
    }
}
