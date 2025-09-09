<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{

    use ApiResponse;


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::with('products')->get();


        // لو الكاتيجوري مش موجود
        if ($categories->isEmpty()) {
            return $this->error('Category not found', [], 404);
        }

        // لو موجود
        return $this->success('Category retrieved successfully', CategoryResource::collection($categories));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
       $category = Category::create($request->validated());
        return $this->success('تم انشاء القسم بنجاح', new CategoryResource($category), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $id)
    {
        //
        $category = Category::with('products')->find($id);

        if ($category) {

            return $this->success('تم جلب القسم', new CategoryResource($category), 200);
        } else {

            return $this->error('القسم غير موجود', [], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {

        //
        $category = Category::find($id);
        if ($category) {
            $category->update($request->validated());
            return $this->success('تم جلب القسم', new CategoryResource($category), 200);
        } else {

            return $this->error('القسم غير موجود', [], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $category = Category::find($id);

    if ($category) {
        $category->delete();
        return $this->success('تم حذف القسم بنجاح',[],200);
    } else {
        return $this->error('القسم غير موجود', [], 404);
    }
}
}