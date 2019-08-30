<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
    * Order model
    *
    * @var \App\Models\Order
    */
    protected $order;

    /**
     * Order service
     *
     * @var \App\Services\OrderService
     */
    protected $order_service;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Models\Order    $orders
     * @param  \App\Services\OrderService  $order_service
     */
    public function __construct(
        Order $order,
        OrderService $order_service
    ) {
        $this->order   = $order;
        $this->order_service = $order_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\OrderStoreRequest  $request
     * @return string
     */
    public function store(OrderStoreRequest $request)
    {
        $validated_data = $request->validated();

        $order = $this->order_service->placeOrder($validated_data['items']);

        return response()->json([
            'message' => 'Order successfully placed!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
