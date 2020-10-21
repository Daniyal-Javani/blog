<?php

namespace App\Listeners;

use App\Mail\SendEmailVerificationMail;
use App\Services\CreateOtpService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationNotification
{
    protected $createOtpService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CreateOtpService $createOtpService)
    {
        $this->createOtpService = $createOtpService;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;

        $code = $this->createOtpService->execute($user);

        Mail::to($user)->send(new SendEmailVerificationMail($code));
    }
}
