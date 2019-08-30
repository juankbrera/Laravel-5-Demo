<?php

namespace App\Http\Controllers;

use App\Events\ProductLike;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
    * Like model
    *
    * @var \App\Models\Like
    */
    public $like;

    /**
    * Product model
    *
    * @var \App\Models\Product
    */
    public $product;

    /**
    * Create a new controller instance.
    *
    * @param  \App\Models\Like         $likes
    * @param  \App\Models\Product      $products
    */
    public function __construct(
        Like $like,
        Product $product
    ) {
        $this->like    = $like;
        $this->product = $product;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product      = $this->product->findOrFail($request->product_id);
        $product_like = $product->likes()->firstOrCreate([
            'user_id' => auth('api')->user()->id
        ]);

        if ($product_like->wasRecentlyCreated) {
            event(new ProductLike($product));
        }

        return response()->json([
            'message' => 'Like stored successfully!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product      = $this->product->findOrFail($request->product_id);
        $product_like = $product->likes()
            ->where('user_id', auth('api')->user()->id)
            ->firstOrFail();

        $product_like->delete();

        event(new ProductLike($product, false));

        return response()->json([
            'message' => 'Like destroyed successfully!'], 201);
    }
}
