<?php

namespace App\Http\Controllers;

use App\Events\ProductLike;
use App\Http\Requests\LikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Models\Product;

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
    public function store(LikeRequest $request)
    {
        $product      = $this->product->findOrFail($request->product_id);
        $product_like = $product->likes()->firstOrCreate([
            'user_id' => auth('api')->user()->id
        ]);

        if ($product_like->wasRecentlyCreated) {
            event(new ProductLike($product));
        }

        return new LikeResource($product_like);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LikeRequest $request, $id)
    {
        $product      = $this->product->findOrFail($request->product_id);
        $product_like = $product->likes()
            ->where('user_id', auth('api')->user()->id)
            ->firstOrFail();

        $product_like->delete();

        event(new ProductLike($product, false));

        return new LikeResource($product_like);
    }
}
