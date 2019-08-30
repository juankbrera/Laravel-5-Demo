<?php

namespace App\Listeners;

use App\Events\OrderItemSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Product;

class ReduceStock
{
    /**
     * Product model
     *
     * @var \App\Models\Product
     */
    protected $product;

    /**
     * Create the event listener.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Handle the event.
     *
     * @param  OrderItemSaved  $event
     * @return void
     */
    public function handle(OrderItemSaved $event)
    {
        $this->product->findOrFail($event->order_item->product_id)
            ->decrement('stock', $event->order_item->quantity);
    }
}
