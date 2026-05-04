<?php

namespace DMO\SavingsBond\Listeners;

use DMO\SavingsBond\Models\BidDeleted;

class BidDeletedListener
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
    public function handle(BidDeleted $event)
    {
        //
    }
}
