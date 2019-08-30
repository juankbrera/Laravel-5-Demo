<?php

namespace App\Services;

use App\Events\OrderItemSaved;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\ProductService;

class OrderService
{
    /**
    * Order model
    *
    * @var \App\Models\Order
    */
    protected $order;

    /**
     * OrderItem model
     *
     * @var \App\Models\OrderItem
     */
    protected $order_item;

    /**
     * Product model
     *
     * @var \App\Models\Product
     */
    protected $product;

    /**
     * Product service
     *
     * @var \App\Services\ProductService
     */
    protected $product_service;

    /**
     * Store the items of the order
     *
     * @var
     */
    protected $order_items;

    /**
     * Create a new class instance.
     *
     * @param  \App\Models\Order    $orders
     * @param  \App\Models\OrderItem  $order_item
     * @param  \App\Models\Product  $product
     * @param  \App\Services\ProductService  $product_service
     */
    public function __construct(
        Order $order,
        OrderItem $order_item,
        Product $product,
        ProductService $product_service
    ) {
        $this->order           = $order;
        $this->order_item      = $order_item;
        $this->product = $product;
        $this->product_service = $product_service;
    }

    public function placeOrder($order_items)
    {
        $this->order_items = $this->itemsList($order_items);

        $avalilable_stock = $this->product_service
            ->availableStock($this->order_items);

        if (!$avalilable_stock) {
            throw new \InvalidArgumentException(
                "There are not enough products to satisfy your order"
            );
        }

        $saved_order          = $this->saveOrder();
        $saved_order['items'] = $this->saveItems($saved_order);

        return $saved_order;
    }

    protected function saveOrder()
    {
        $order = $this->order->create([
            'order_number' => uniqid(),
            'user_id' => auth('api')->user()->id,
            'total_amount' => $this->totalAmount(),
            'is_placed' => true
        ]);

        return $order;
    }

    protected function saveItems($order)
    {
        foreach ($this->order_items as $item) {
            $order_item = $this->order_item->create([
                'quantity'   => $item->requested_quantity,
                'unit_price' => $item->price,
                'total_price' => $item->price * $item->requested_quantity,
                'order_id' => $order->id,
                'product_id' => $item->id
            ]);

            //Trigger an event to reduce the product stock
            event(new OrderItemSaved($order_item));

            $order_items[] = $order_item;
        }

        return $order_items;
    }

    protected function itemsList($items)
    {
        $items = collect($items);

        foreach ($items as $item) {
            $product = $this->product
                ->where('is_active', true)
                ->findOrFail($item['id']);

            $product['requested_quantity'] = $item['quantity'];

            $products[] = $product;
        }

        return $products;
    }

    protected function totalAmount()
    {
        $total_amount = 0;

        foreach ($this->order_items as $item) {
            $total_amount = $total_amount +
                ($item->price * $item->requested_quantity);
        }

        return $total_amount;
    }
}
