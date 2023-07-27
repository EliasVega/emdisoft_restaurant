<?php

namespace App\Http\Controllers;

use App\Models\MenuProduct;
use App\Http\Requests\StoreMenuProductRequest;
use App\Http\Requests\UpdateMenuProductRequest;

class MenuProductController extends Controller
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
     * @param  \App\Http\Requests\StoreMenuProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuProduct  $menuProduct
     * @return \Illuminate\Http\Response
     */
    public function show(MenuProduct $menuProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuProduct  $menuProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuProduct $menuProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuProductRequest  $request
     * @param  \App\Models\MenuProduct  $menuProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuProductRequest $request, MenuProduct $menuProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuProduct  $menuProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuProduct $menuProduct)
    {
        //
    }
}
