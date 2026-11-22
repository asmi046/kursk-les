<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail implements ShouldQueue
{
    public function handle(OrderCreated $event): void
    {
        $emails = config('order.notify_emails', []);

        if ($emails === []) {
            return;
        }

        Mail::to($emails)->send(new OrderCreatedMail($event->order));
    }
}
