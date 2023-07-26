<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Http\Requests\StoreTaxRequest;
use App\Http\Requests\UpdateTaxRequest;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $taxes = Tax::get();

            return datatables()
            ->of($taxes)
            ->addColumn('edit', 'admin/tax/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.tax.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tax.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTaxRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaxRequest $request)
    {
        $tax = new Tax();
        $tax->code = $request->code;
        $tax->name = $request->name;
        $tax->description = $request->description;
        $tax->save();
        return redirect("tax");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit($tax)
    {
        $tax = Tax::findOrFail($tax);
        return view('admin.tax.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaxRequest  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxRequest $request, $tax)
    {
        $tax = Tax::findOrFail($tax);
        $tax->code = $request->code;
        $tax->name = $request->name;
        $tax->description = $request->description;
        $tax->update();
        return redirect('tax');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        //
    }
}
