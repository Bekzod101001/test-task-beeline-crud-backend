<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\Product\IndexProductResource;
use App\Http\Resources\Product\SingleProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortBy = $request->sortBy ?? 'created_at';
        $sortType = $request->sortType ?? 'desc';
        $products = Product::query()
            ->when($request->search, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->priceFrom, function ($query) use ($request) {
                return $query->where('price', '<=', $request->priceFrom);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                return $query->where('price', '>=', $request->priceTo);
            })
            ->when($request->ownerId, function ($query) use ($request) {
                return $query->where('user_id', $request->ownerId);
            })
            ->orderBy($sortBy, $sortType)
            ->paginate($request->perPage ?? 20);


        return $this->successPagination(IndexProductResource::class, $products);
    }

    /**
     * Return ALL records
     */
    public function list()
    {
        $products = Product::all();
        return $this->success(IndexProductResource::collection($products));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $newProduct = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'small_description' => $request->smallDescription,
            'price' => $request->price,
            'user_id' => $request->ownerId,
        ]);

        return $this->success(new SingleProductResource($newProduct), null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->success(new SingleProductResource($product));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'small_description' => $request->smallDescription,
            'price' => $request->price,
            'user_id' => $request->ownerId
        ]);

        return $this->success('Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->success('Product successfully deleted');
    }
}
