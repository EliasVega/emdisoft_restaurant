<?php

namespace App\Http\Controllers;

use App\Models\Type_document;
use App\Http\Requests\StoreType_documentRequest;
use App\Http\Requests\UpdateType_documentRequest;

class TypeDocumentController extends Controller
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
            $type_documents = Type_document::get();
            return DataTables()::of($type_documents)
            ->addColumn('edit', 'admin/type_document/actions')
            ->rawColumns(['edit'])
            ->toJson();
        }
        return view('admin.type_document.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.type_document.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreType_documentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreType_documentRequest $request)
    {
        $type_document = new Type_document();
        $type_document->code = $request->code;
        $type_document->name = $request->name;
        $type_document->prefix = $request->prefix;
        $type_document->cufe_algorithm = $request->cufe_algorithm;
        $type_document->save();
        return redirect('type_document');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type_document  $type_document
     * @return \Illuminate\Http\Response
     */
    public function show(Type_document $type_document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type_document  $type_document
     * @return \Illuminate\Http\Response
     */
    public function edit(Type_document $type_document)
    {
        $type_document = Type_document::findOrFail($type_document->id);

        return view('admin.type_document.edit', compact('type_document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateType_documentRequest  $request
     * @param  \App\Models\Type_document  $type_document
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateType_documentRequest $request, Type_document $type_document)
    {
        $type_document = Type_document::findOrFail($type_document->id);
        $type_document->code = $request->code;
        $type_document->name = $request->name;
        $type_document->prefix = $request->prefix;
        $type_document->cufe_algorithm = $request->cufe_algorithm;
        $type_document->update();

        return redirect('type_document');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type_document  $type_document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type_document $type_document)
    {
        //
    }
}
