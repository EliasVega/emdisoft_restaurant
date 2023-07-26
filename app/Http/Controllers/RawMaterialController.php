<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Http\Requests\StoreRawMaterialRequest;
use App\Http\Requests\UpdateRawMaterialRequest;
use App\Models\Category;
use App\Models\Unit_measure;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $rawMaterials = RawMaterial::get();

            return datatables()
            ->of($rawMaterials)
            ->addIndexColumn()
            ->addColumn('unitMeasure', function (RawMaterial $rawMaterial) {
                return $rawMaterial->unitMeasure->name;
            })
            ->addColumn('edit', 'admin/raw_material/actions')
            ->rawcolumns(['edit'])
            ->toJson();
        }
        return view('admin.raw_material.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $measures = Unit_measure::where('status', 'activo')->get();

        return view("admin.raw_material.create", compact('categories', 'measures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRawMaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRawMaterialRequest $request)
    {
        $rawMaterial = new RawMaterial();
        $rawMaterial->category_id = $request->category_id;
        $rawMaterial->unit_measure_id = $request->unit_measure_id;
        $rawMaterial->code = $request->code;
        $rawMaterial->name = $request->name;
        $rawMaterial->price = $request->price;
        $rawMaterial->stock = 0;
        $rawMaterial->save();

        return redirect('rawMaterial');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RawMaterial  $rawMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(RawMaterial $rawMaterial)
    {
        $categories = Category::select('id', 'name')->get();

        return view("admin.raw_material.show", compact('rawMaterial', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RawMaterial  $rawMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(RawMaterial $rawMaterial)
    {
        $categories = Category::select('id', 'name')->get();
        $measures = Unit_measure::where('status', 'activo')->get();

        return view("admin.raw_material.edit", compact('rawMaterial', 'categories', 'measures'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRawMaterialRequest  $request
     * @param  \App\Models\RawMaterial  $rawMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRawMaterialRequest $request, RawMaterial $rawMaterial)
    {
        $rawMaterial->category_id = $request->category_id;
        $rawMaterial->unit_measure_id = $request->unit_measure_id;
        $rawMaterial->code = $request->code;
        $rawMaterial->name = $request->name;
        $rawMaterial->price = $request->price;
        $rawMaterial->update();

        return redirect('rawMaterial');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RawMaterial  $rawMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        //
    }

    public function status($id)
    {

        $rawMaterial = RawMaterial::findOrFail($id);
        if ($rawMaterial->status == 'active') {
            $rawMaterial->status = 'inactive';
        } else {
            $rawMaterial->status = 'active';
        }
        $rawMaterial->update();

        return redirect('rawMaterial');
    }
}
