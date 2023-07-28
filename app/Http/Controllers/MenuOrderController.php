<?php

namespace App\Http\Controllers;

use App\Models\MenuOrder;
use App\Http\Requests\StoreMenuOrderRequest;
use App\Http\Requests\UpdateMenuOrderRequest;

class MenuOrderController extends Controller
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
     * @param  \App\Http\Requests\StoreMenuOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return \Illuminate\Http\Response
     */
    public function show(MenuOrder $menuOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuOrder $menuOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuOrderRequest  $request
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuOrderRequest $request, MenuOrder $menuOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuOrder $menuOrder)
    {
        //
    }
}
