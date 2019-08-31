<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use FileUploadTrait;

    /**
     * Product model
     *
     * @var \App\Models\Product
     */
    protected $product;

    /**
     * Create a new controller instance.
     *
     * @param \App\Models\Product $products
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return App\Http\Resources\ProductResource
     */
    public function index(Request $request)
    {
        $products = $this->product
            ->where('is_active', true)
            ->search($request->search_term)
            ->orderBy((isset($request->order_by) ? $request->order_by : 'name'), 'desc')
            ->paginate(10);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ProductStoreRequest $request
     * @return App\Http\Resources\ProductResource
     */
    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create', Product::class);

        $validated_data = $request->validated();

        if (isset($validated_data['photo'])) {
            $validated_data['photo'] =
                $this->uploadFile($request->photo, 'images/products');
        }

        $product = $this->product->create($validated_data);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @return App\Http\Resources\ProductResource
     */
    public function show($product_id)
    {
        $product = $this->product
            ->where('is_active', true)
            ->findOrFail($product_id);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductUpdateRequest $request
     * @param  int $product_id
     * @return App\Http\Resources\ProductResource
     */
    public function update(ProductUpdateRequest $request, $product_id)
    {
        $this->authorize('update', Product::class);

        $product        = $this->product->findOrFail($product_id);
        $validated_data = $request->validated();

        if (isset($validated_data['photo'])) {
            $validated_data['photo'] =
                $this->uploadFile($request->photo, 'images/products');
        }
        
        $product->fill($validated_data);
        $product->save();

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $product_id
     * @return App\Http\Resources\ProductResource
     */
    public function destroy($product_id)
    {
        $this->authorize('delete', Product::class);

        $product = $this->product->findOrFail($product_id);
        $product->delete();

        return new ProductResource($product);
    }
}
