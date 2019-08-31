<?php

namespace App\Http\Controllers;

use App\Events\ProductLike;
use App\Http\Requests\LikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Product;

class LikesController extends Controller
{
    /**
    * Product model
    *
    * @var \App\Models\Product
    */
    public $product;

    /**
    * Create a new controller instance.
    *
    * @param  \App\Models\Product      $products
    */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Resources\LikeResource $request
     * @return App\Http\Resources\LikeResource
     */
    public function store(LikeRequest $request)
    {
        $product      = $this->product->findOrFail($request->product_id);
        $product_like = $product->likes()->firstOrCreate([
            'user_id' => auth('api')->user()->id
        ]);

        if ($product_like->wasRecentlyCreated) {
            // Update the product like_count
            event(new ProductLike($product));
        }

        return new LikeResource($product_like);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\Requests\LikeRequest $request
     * @return App\Http\Resources\LikeResource
     */
    public function destroy(LikeRequest $request)
    {
        $product      = $this->product->findOrFail($request->product_id);
        $product_like = $product->likes()
            ->where('user_id', auth('api')->user()->id)
            ->firstOrFail();

        $product_like->delete();

        // Update the product like_count
        event(new ProductLike($product, false));

        return new LikeResource($product_like);
    }
}
