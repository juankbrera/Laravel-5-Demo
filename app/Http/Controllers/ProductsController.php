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
            ->orderBy((isset($request->order_by) ? $request->order_by : 'name'))
            ->paginate(20);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ProductStoreRequest $request
     * @return string
     */
    public function store(ProductStoreRequest $request)
    {
        $validated_data = $request->validated();
        $validated_data['photo'] =
            $this->uploadFile($request->photo, 'images/products');

        $product = $this->product->create($validated_data);

        return response()->json([
            'message' => 'Product successfully created!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return App\Http\Resources\ProductResource
     */
    public function show($id)
    {
        $product = $this->product
            ->where('is_active', true)
            ->findOrFail($id);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductUpdateRequest $request
     * @param  int $id
     * @return string
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = $this->product->findOrFail($id);
        $validated_data = $request->validated();

        if (isset($validated_data['photo'])) {
            $validated_data['photo'] =
                $this->uploadFile($request->photo, 'images/products');
        }

        $product->fill($validated_data);
        $product->save();

        return response()->json([
            'message' => 'Product successfully updated!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return string
     */
    public function destroy($id)
    {
        $product = $this->product->findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product successfully deleted!'], 201);
    }
}
