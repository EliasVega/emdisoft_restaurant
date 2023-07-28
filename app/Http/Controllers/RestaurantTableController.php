<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use App\Http\Requests\StoreRestaurantTableRequest;
use App\Http\Requests\UpdateRestaurantTableRequest;
use App\Models\Branch;

class RestaurantTableController extends Controller
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
            $tables = RestaurantTable::get();
            return DataTables()::of($tables)
            ->addIndexColumn()
            ->addColumn('branch', function (RestaurantTable $table) {
                return $table->branch->name;
            })
            ->addColumn('editar', 'admin/restaurantTable/actions')
            ->rawColumns(['editar'])
            ->toJson();
        }
        return view('admin.restaurantTable.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::get();
        return view("admin.restaurantTable.create", compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRestaurantTableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRestaurantTableRequest $request)
    {
        $table = new RestaurantTable();
        $table->branch_id = $request->branch_id;
        $table->name = $request->name;
        $table->save();
        return redirect('restaurantTable');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RestaurantTable  $restaurantTable
     * @return \Illuminate\Http\Response
     */
    public function show(RestaurantTable $restaurantTable)
    {
        return view("admin.restaurantTable.show", compact('restaurantTable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RestaurantTable  $restaurantTable
     * @return \Illuminate\Http\Response
     */
    public function edit(RestaurantTable $restaurantTable)
    {
        $branches = Branch::get();

        return view("admin.restaurantTable.edit", compact('restaurantTable', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRestaurantTableRequest  $request
     * @param  \App\Models\RestaurantTable  $restaurantTable
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRestaurantTableRequest $request, RestaurantTable $restaurantTable)
    {
        $restaurantTable->branch_id = $request->branch_id;
        $restaurantTable->name = $request->name;
        $restaurantTable->update();
        return redirect('restaurantTable');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RestaurantTable  $restaurantTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(RestaurantTable $restaurantTable)
    {
        //
    }
}
