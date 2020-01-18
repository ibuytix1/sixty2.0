<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Model\organizer\ContactModel;
use Illuminate\Support\Facades\DB;

class SendMailFired
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
     * @param SendMail $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        $data = ContactModel::WhereIn('id', $event->userIds)
            ->select('email', DB::raw('CONCAT(first_Name, " ", last_Name) AS full_name'))->get();
        foreach ($data as $key => $userdata) {
            $email = $userdata->email;
            Mail::send('mails.notification', [
                'title' => 'Notification',
                'description' => $event->message,
                'name' => $userdata->full_name
            ], function ($message) use ($email) {
                $message->to($email)->subject("Notification");
            });
        }
    }
}
