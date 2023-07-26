<?php

namespace App\Http\Controllers;

use App\Models\Software;
use App\Http\Requests\StoreSoftwareRequest;
use App\Http\Requests\UpdateSoftwareRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $software = Software::get();

            return DataTables::of($software)
                ->addIndexColumn()
                ->addColumn('company', function (Software $software) {
                    return $software->company->name;
                })
                ->addColumn('edit', 'admin/software/actions')
                ->rawColumns(['edit'])
                ->make(true);
        }

        return view('admin.software.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.software.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSoftwareRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSoftwareRequest $request)
    {
        $software = new Software();
        $software->company_id = 1;
        $software->identifier = $request->identifier;
        $software->pin = $request->pin;
        $software->set = $request->set;
        $software->payroll_identifier = $request->payroll_identifier;
        $software->payroll_pin = $request->payroll_pin;
        $software->payroll_set = $request->payroll_set;
        $software->save();

        return redirect('software');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function show(Software $software)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function edit(Software $software)
    {
        $software = Software::findOrFail($software->id);
        return view('admin.software.update', compact('software'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSoftwareRequest  $request
     * @param  \App\Models\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSoftwareRequest $request, Software $software)
    {
        $software = Software::findOrFail($software->id);
        $software->company_id = 1;
        $software->identifier = $request->identifier;
        $software->pin = $request->pin;
        $software->set = $request->set;
        $software->payroll_identifier = $request->payroll_identifier;
        $software->payroll_pin = $request->payroll_pin;
        $software->payroll_set = $request->payroll_set;
        $software->update();

        return redirect('software');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Software  $software
     * @return \Illuminate\Http\Response
     */
    public function destroy(Software $software)
    {
        //
    }
}
