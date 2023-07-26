<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Http\Requests\StoreIndicatorRequest;
use App\Http\Requests\UpdateIndicatorRequest;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $indicators = Indicator::get();

            return datatables()
            ->of($indicators)
            ->addColumn('restaurant', 'admin/indicator/restaurant')
            ->rawcolumns(['restaurant'])
            ->toJson();
        }
        return view('admin.indicator.index');
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
     * @param  \App\Http\Requests\StoreIndicatorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIndicatorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIndicatorRequest  $request
     * @param  \App\Models\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIndicatorRequest $request, Indicator $indicator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indicator  $indicator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indicator $indicator)
    {
        //
    }

    public function restaurantStatus($id)
    {

        $indicator = Indicator::findOrFail($id);
        if ($indicator->restaurant == 'on') {
            $indicator->restaurant = 'off';
        } else {
            $indicator->restaurant = 'on';
        }
        $indicator->update();

        return redirect('indicator');
    }
}
