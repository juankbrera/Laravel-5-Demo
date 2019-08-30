<?php

namespace App\Listeners;

use App\Events\ProductLike;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLikeCount
{
    /**
     * Create the event listener.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductLike  $event
     * @return void
     */
    public function handle(ProductLike $event)
    {
        if ($event->like) {
            $event->product->increment('like_count');
        } else {
            $event->product->decrement('like_count');
        }
    }
}
