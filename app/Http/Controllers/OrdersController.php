<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrdersController extends Controller
{
    /**
     * Order service
     *
     * @var \App\Services\OrderService
     */
    protected $order_service;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\OrderService  $order_service
     */
    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\OrderStoreRequest  $request
     * @return App\Http\Resources\OrderResource
     */
    public function store(OrderStoreRequest $request)
    {
        $validated_data = $request->validated();
        $order          = $this->order_service
                            ->placeOrder($validated_data['items']);

        return new OrderResource($order);
    }
}
