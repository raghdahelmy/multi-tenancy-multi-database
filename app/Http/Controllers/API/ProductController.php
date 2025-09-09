<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return $this->error('لا توجد منتجات', [], 404);
        }

        return $this->success('تم جلب المنتجات بنجاح', ProductResource::collection($products));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return $this->success('تم انشاء المنتج بنجاح', new ProductResource($product), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return $this->success('تم جلب المنتج', new ProductResource($product), 200);
        }

        return $this->error('المنتج غير موجود', [], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->update($request->validated());
            return $this->success('تم تحديث المنتج', new ProductResource($product), 200);
        }

        return $this->error('المنتج غير موجود', [], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return $this->success('تم حذف المنتج بنجاح', [], 200);
        }

        return $this->error('المنتج غير موجود', [], 404);
    }
}
