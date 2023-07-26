<?php

namespace App\Http\Controllers;

use App\Models\Regime;
use App\Http\Requests\StoreRegimeRequest;
use App\Http\Requests\UpdateRegimeRequest;

class RegimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $regimes = Regime::get();

            return datatables()
            ->of($regimes)
            ->addColumn('edit', 'admin/regime/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.regime.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.regime.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegimeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegimeRequest $request)
    {
        $regime = new Regime();
        $regime->code = $request->code;
        $regime->name = $request->name;
        $regime->save();
        return redirect("regime");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regime  $regime
     * @return \Illuminate\Http\Response
     */
    public function show(Regime $regime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Regime  $regime
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regime = Regime::findOrFail($id);
        return view('admin.regime.edit', compact('regime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegimeRequest  $request
     * @param  \App\Models\Regime  $regime
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegimeRequest $request, $id)
    {
        $regime = Regime::findOrFail($id);
        $regime->code = $request->code;
        $regime->name = $request->name;
        $regime->update();
        return redirect('regime');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Regime  $regime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regime $regime)
    {
        //
    }
}
