<?php

namespace App\Http\Controllers;

use App\Models\Discharge_receipt;
use App\Http\Requests\StoreDischarge_receiptRequest;
use App\Http\Requests\UpdateDischarge_receiptRequest;

class DischargeReceiptController extends Controller
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
     * @param  \App\Http\Requests\StoreDischarge_receiptRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDischarge_receiptRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discharge_receipt  $discharge_receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Discharge_receipt $discharge_receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discharge_receipt  $discharge_receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Discharge_receipt $discharge_receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDischarge_receiptRequest  $request
     * @param  \App\Models\Discharge_receipt  $discharge_receipt
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDischarge_receiptRequest $request, Discharge_receipt $discharge_receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discharge_receipt  $discharge_receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discharge_receipt $discharge_receipt)
    {
        //
    }
}
