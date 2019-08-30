<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductLike
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Product model
     *
     * @var \App\Models\Product
     */
    public $product;

    /**
     * like option
     *
     * @var boolean
     */
    public $like;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function __construct($product, $like = true)
    {
        $this->product = $product;
        $this->like = $like;
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
