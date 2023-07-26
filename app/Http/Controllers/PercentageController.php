<?php

namespace App\Http\Controllers;

use App\Models\Percentage;
use App\Http\Requests\StorePercentageRequest;
use App\Http\Requests\UpdatePercentageRequest;

class PercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $percentages = Percentage::get();

            return datatables()
            ->of($percentages)
            ->addColumn('edit', 'admin/percentage/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.percentage.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.percentage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePercentageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePercentageRequest $request)
    {
        $percentage = new Percentage();
        $percentage->percentage = $request->percentage;
        $percentage->base = $request->base;
        $percentage->save();
        return redirect("percentage");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Percentage  $percentage
     * @return \Illuminate\Http\Response
     */
    public function show(Percentage $percentage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Percentage  $percentage
     * @return \Illuminate\Http\Response
     */
    public function edit(Percentage $percentage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePercentageRequest  $request
     * @param  \App\Models\Percentage  $percentage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePercentageRequest $request, Percentage $percentage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Percentage  $percentage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Percentage $percentage)
    {
        //
    }
}
