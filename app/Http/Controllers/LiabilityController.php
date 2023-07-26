<?php

namespace App\Http\Controllers;

use App\Models\Liability;
use App\Http\Requests\StoreLiabilityRequest;
use App\Http\Requests\UpdateLiabilityRequest;

class LiabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $liabilities = Liability::get();

            return datatables()
            ->of($liabilities)
            ->addColumn('edit', 'admin/liability/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.liability.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.liability.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLiabilityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLiabilityRequest $request)
    {
        $liability = new Liability();
        $liability->code = $request->code;
        $liability->name = $request->name;
        $liability->save();

        return redirect('liability');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Liability  $liability
     * @return \Illuminate\Http\Response
     */
    public function show(Liability $liability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liability  $liability
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $liability = Liability::findOrFail($id);
        return view('admin.liability.edit', compact('liability'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLiabilityRequest  $request
     * @param  \App\Models\Liability  $liability
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLiabilityRequest $request, $id)
    {
        $liability = Liability::findOrFail($id);
        $liability->code = $request->code;
        $liability->name = $request->name;
        $liability->update();

        return redirect('liability');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liability  $liability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liability $liability)
    {
        //
    }
}
