<?php

namespace DMO\SavingsBond\Listeners;

use DMO\SavingsBond\Models\SubscriptionDeleted;

class SubscriptionDeletedListener
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
     * @return void
     */
    public function handle(SubscriptionDeleted $event)
    {
        //
    }
}
