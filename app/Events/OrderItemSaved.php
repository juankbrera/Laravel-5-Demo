<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderItemSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * OrderItem model
     *
     * @var \App\Models\OrderItem
     */
    public $order_item;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\OrderItem  $order_item
     * @return void
     */
    public function __construct($order_item)
    {
        $this->order_item = $order_item;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
