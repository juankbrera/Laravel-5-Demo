<?php

namespace App\Listeners;

use App\Events\OrderItemSaved;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
