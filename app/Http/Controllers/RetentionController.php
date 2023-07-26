<?php

namespace App\Http\Controllers;

use App\Models\Retention;
use App\Http\Requests\StoreRetentionRequest;
use App\Http\Requests\UpdateRetentionRequest;

class RetentionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $retentions = Retention::get();

            return datatables()
            ->of($retentions)
            ->addColumn('edit', 'admin/retention/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.retention.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.retention.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRetentionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRetentionRequest $request)
    {
        $retention = new Retention();
        $retention->porcentage = $request->porcentage;
        $retention->base = $request->base;
        $retention->save();
        return redirect("retention");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Retention  $retention
     * @return \Illuminate\Http\Response
     */
    public function show(Retention $retention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Retention  $retention
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $retention = Retention::findOrFail($id);
        return view('admin.retention.edit', compact('retention'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRetentionRequest  $request
     * @param  \App\Models\Retention  $retention
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRetentionRequest $request, $id)
    {
        $retention = Retention::findOrFail($id);
        $retention->porcentage = $request->porcentage;
        $retention->base = $request->base;
        $retention->update();
        return redirect('retention');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Retention  $retention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retention $retention)
    {
        //
    }
}
