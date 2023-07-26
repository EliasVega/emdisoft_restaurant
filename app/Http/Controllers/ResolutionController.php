<?php

namespace App\Http\Controllers;

use App\Models\Resolution;
use App\Http\Requests\StoreResolutionRequest;
use App\Http\Requests\UpdateResolutionRequest;
use App\Models\Company;
use App\Models\Type_document;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $resolutions = Resolution::get();

            return DataTables::of($resolutions)
                ->addIndexColumn()
                ->addColumn('company', function (Resolution $resolution) {
                    return $resolution->company->name;
                })
                ->addColumn('document', function (Resolution $resolution) {
                    return $resolution->type_document->name;
                })
                ->addColumn('numeration', function(Resolution $resolution){
                    return $resolution->start_number . ' -- ' . $resolution->end_number;
                })
                ->editColumn('resolution_date', function($resolutions){
                    return $resolutions->resolution_date->format('yy-m-d');
                })
                ->editColumn('start_date', function($resolutions){
                    return $resolutions->start_date->format('yy-m-d');
                })
                ->editColumn('end_date', function($resolutions){
                    return $resolutions->end_date->format('yy-m-d');
                })
                ->addColumn('edit', 'admin/resolution/actions')
                ->rawColumns(['edit'])
                ->make(true);
        }

        return view('admin.resolution.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::findOrFail(1);
        $type_documents = Type_document::get();
        return view('admin.resolution.create', compact('type_documents', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreResolutionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResolutionRequest $request)
    {
        $resolution = new Resolution();
        $resolution->company_id = 1;
        $resolution->type_document_id = $request->type_document_id;
        $resolution->consecutive = $request->consecutive;
        $resolution->prefix = $request->prefix;
        $resolution->resolution = $request->resolution;
        $resolution->resolution_date = $request->resolution_date;
        $resolution->technical_key = $request->technical_key;
        $resolution->start_number = $request->start_number;
        $resolution->end_number = $request->end_number;
        $resolution->start_date = $request->start_date;
        $resolution->end_date = $request->end_date;
        $resolution->status = 'active';
        $resolution->save();

        return redirect('resolution');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function show(Resolution $resolution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function edit(Resolution $resolution)
    {
        $companies = Company::findOrFail(1);
        $type_documents = Type_document::get();
        return view('admin.resolution.edit', compact('resolution', 'type_documents', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResolutionRequest  $request
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResolutionRequest $request, Resolution $resolution)
    {
        $resolution = Resolution::findOrFail($resolution->id);

        $resolution->company_id = 1;
        $resolution->type_document_id = $request->type_document_id;
        $resolution->consecutive = $request->consecutive;
        $resolution->prefix = $request->prefix;
        $resolution->resolution = $request->resolution;
        $resolution->resolution_date = $request->resolution_date;
        $resolution->technical_key = $request->technical_key;
        $resolution->start_number = $request->start_number;
        $resolution->end_number = $request->end_number;
        $resolution->start_date = $request->start_date;
        $resolution->end_date = $request->end_date;
        $resolution->status = 'ACTIVA';
        $resolution->update();
        return redirect('resolution');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resolution $resolution)
    {
        //
    }
}
