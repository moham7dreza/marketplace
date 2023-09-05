<?php

namespace App\Observers;

use App\Models\ItemDelivery;

class ItemDeliveryObserver
{
    /**
     * Handle the ItemDelivery "created" event.
     */
    public function created(ItemDelivery $itemDelivery): void
    {
        $itemDelivery->product()->increment('price', $itemDelivery->amount);
    }

    /**
     * Handle the ItemDelivery "updated" event.
     */
    public function updated(ItemDelivery $itemDelivery): void
    {
        $itemDelivery->product()->increment('price', $itemDelivery->amount);
    }

    /**
     * Handle the ItemDelivery "deleted" event.
     */
    public function deleted(ItemDelivery $itemDelivery): void
    {
        $itemDelivery->product()->decrement('price', $itemDelivery->amount);
    }

    /**
     * Handle the ItemDelivery "restored" event.
     */
    public function restored(ItemDelivery $itemDelivery): void
    {
        //
    }

    /**
     * Handle the ItemDelivery "force deleted" event.
     */
    public function forceDeleted(ItemDelivery $itemDelivery): void
    {
        //
    }
}
