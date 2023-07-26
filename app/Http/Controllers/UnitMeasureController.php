<?php

namespace App\Http\Controllers;

use App\Models\Unit_measure;
use App\Http\Requests\StoreUnit_measureRequest;
use App\Http\Requests\UpdateUnit_measureRequest;

class UnitMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax())
        {
            $unit_measures = Unit_measure::get();
            return DataTables()::of($unit_measures)
            ->addColumn('edit', 'admin/unit_measure/actions')
            ->rawColumns(['edit'])
            ->toJson();
        }
        return view('admin.unit_measure.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.unit_measure.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUnit_measureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnit_measureRequest $request)
    {
        $unit_measure = new Unit_measure();
        $unit_measure = $request->code;
        $unit_measure->name = $request->name;
        $unit_measure->save();
        return redirect('unit_measure');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit_measure  $unit_measure
     * @return \Illuminate\Http\Response
     */
    public function show(Unit_measure $unit_measure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit_measure  $unit_measure
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit_measure $unit_measure)
    {
        return view("admin.unit_measure.edit", compact('unit_measure'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUnit_measureRequest  $request
     * @param  \App\Models\Unit_measure  $unit_measure
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnit_measureRequest $request, Unit_measure $unit_measure)
    {
        $unit_measure = Unit_measure::findOrFail($unit_measure);
        $unit_measure->name = $request->name;
        $unit_measure->update();
        return redirect('unit_measure');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit_measure  $unit_measure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit_measure $unit_measure)
    {
        //
    }

    public function status($id)
    {

        $unitMeasure = Unit_measure::findOrFail($id);
        if ($unitMeasure->status == 'activo') {
            $unitMeasure->status = 'inactivo';
        } else {
            $unitMeasure->status = 'activo';
        }
        $unitMeasure->update();

        return redirect('unit_measure');
    }
}
