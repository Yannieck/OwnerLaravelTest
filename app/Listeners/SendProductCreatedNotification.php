<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Notifications\ProductCreatedNotification;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
class SendProductCreatedNotification
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
     * @param  ProductCreated  $event
     * @return void
     */
    public function handle(ProductCreated $event)
    {
        $product = $event->product;
        $users = User::all();

        Notification::send($users, new ProductCreatedNotification($product));
    }
}
