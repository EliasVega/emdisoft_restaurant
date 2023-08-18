<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Document;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $suppliers = Supplier::get();

            return DataTables::of($suppliers)
            ->addIndexColumn()
            ->addColumn('document', function (Supplier $supplier) {
                return $supplier->document->initial;
            })
            ->addColumn('edit', 'admin/supplier/actions')
            ->rawcolumns(['edit'])
            ->make(true);
        }
        return view('admin.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = Document::get();
        return view('admin.supplier.create', compact('documents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSupplierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        $branch = $request->session()->get('branch');
        $nitSupplier = Supplier::get();
        foreach ($nitSupplier as $key => $nitSup) {
            if ($nitSup->number == $request->number) {
                Alert::success('Ya existe','Proveedor con esta identificacion.');
                return redirect('back');
            }
            if ($nitSup->number == $request->number) {
                Alert::success('Ya existe','Proveedor con este Correo electronico.');
                return redirect('back');
            }
        }

        $supplier = new Supplier();
        $supplier->document_id = $request->document_id;
        $supplier->name = $request->name;
        $supplier->number = $request->number;
        $supplier->email = $request->email;
        $supplier->save();

        if($branch > 0)
        {
            return redirect("purchase/create");
        }
        else{
            return redirect('supplier');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $documents = Document::get();
        return view('admin.supplier.edit', compact('supplier', 'documents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSupplierRequest  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->document_id = $request->document_id;
        $supplier->name = $request->name;
        $supplier->number = $request->number;
        $supplier->email = $request->email;
        $supplier->update();
        return redirect('supplier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
