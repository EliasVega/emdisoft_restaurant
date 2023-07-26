<?php

namespace App\Http\Controllers;

use App\Models\ProductRawMaterial;
use App\Http\Requests\StoreProductRawMaterialRequest;
use App\Http\Requests\UpdateProductRawMaterialRequest;

class ProductRawMaterialController extends Controller
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRawMaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRawMaterialRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductRawMaterial  $productRawMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRawMaterial $productRawMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductRawMaterial  $productRawMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRawMaterial $productRawMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRawMaterialRequest  $request
     * @param  \App\Models\ProductRawMaterial  $productRawMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRawMaterialRequest $request, ProductRawMaterial $productRawMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductRawMaterial  $productRawMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRawMaterial $productRawMaterial)
    {
        //
    }
}
