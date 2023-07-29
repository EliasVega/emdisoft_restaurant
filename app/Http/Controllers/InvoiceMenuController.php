<?php

namespace App\Http\Controllers;

use App\Models\InvoiceMenu;
use App\Http\Requests\StoreInvoiceMenuRequest;
use App\Http\Requests\UpdateInvoiceMenuRequest;

class InvoiceMenuController extends Controller
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
     * @param  \App\Http\Requests\StoreInvoiceMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceMenuRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceMenu  $invoiceMenu
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceMenu $invoiceMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceMenu  $invoiceMenu
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceMenu $invoiceMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInvoiceMenuRequest  $request
     * @param  \App\Models\InvoiceMenu  $invoiceMenu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceMenuRequest $request, InvoiceMenu $invoiceMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceMenu  $invoiceMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceMenu $invoiceMenu)
    {
        //
    }
}
