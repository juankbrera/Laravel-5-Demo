<?php

namespace App\Services;

class ProductService
{
    /**
     * Check if there are enough products in stock to place an order
     *
     * @param  array $order_items
     * @return boolean
     */
    public function availableStock($order_items)
    {
        foreach ($order_items as $order_item) {
            if ($order_item->stock < $order_item->requested_quantity) {
                return false;
            }
        }

        return true;
    }
}
