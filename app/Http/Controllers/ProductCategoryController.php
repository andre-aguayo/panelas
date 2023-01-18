<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryCreateRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Services\Product\Interfaces\ProductCategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoryController extends Controller
{

    public function __construct(private ProductCategoryServiceInterface $productCategoryService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Collection
    {
        return $this->productCategoryService->list();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryCreateRequest $productCategoryCreateRequest)
    {
        return $this->productCategoryService->store($productCategoryCreateRequest);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $productCategory)
    {
        return $this->productCategoryService->show($productCategory->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryUpdateRequest $productCategoryUpdateRequest)
    {
        return $this->productCategoryService->update($productCategoryUpdateRequest);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->productCategoryService->destroy($request->id);
    }
}
