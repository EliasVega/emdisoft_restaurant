<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Department;
use App\Models\Document;
use App\Models\Liability;
use App\Models\Municipality;
use App\Models\Organization;
use App\Models\Regime;
use Illuminate\Http\Request;
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
                ->addColumn('liability', function (Supplier $supplier) {
                    return $supplier->liability->name;
                })
                ->addColumn('organization', function (Supplier $supplier) {
                    return $supplier->organization->name;
                })
                ->addColumn('regime', function (Supplier $supplier) {
                    return $supplier->regime->name;
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
        $departments = Department::get();
        $municipalities = Municipality::get();
        $documents = Document::get();
        $liabilities = Liability::get();
        $organizations = Organization::get();
        $regimes = Regime::get();
        return view('admin.supplier.create', compact('departments', 'municipalities', 'documents', 'liabilities', 'organizations', 'regimes'));
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
        $nitS = 0;
        $emailS = 0;
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
        $supplier->department_id = $request->department_id;
        $supplier->municipality_id = $request->municipality_id;
        $supplier->document_id = $request->document_id;
        $supplier->liability_id = $request->liability_id;
        $supplier->organization_id = $request->organization_id;
        $supplier->regime_id = $request->regime_id;
        $supplier->name = $request->name;
        $supplier->number = $request->number;
        $supplier->dv = $request->dv;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->contact = $request->contact;
        $supplier->phone_contact = $request->phone_contact;
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
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $departments = Department::get();
        $municipalities = Municipality::get();
        $documents = Document::get();
        $liabilities = Liability::get();
        $organizations = Organization::get();
        $regimes = Regime::get();
        return view('admin.supplier.edit', compact('supplier', 'departments', 'municipalities', 'documents', 'liabilities', 'organizations', 'regimes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSupplierRequest  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->department_id = $request->department_id;
        $supplier->municipality_id = $request->municipality_id;
        $supplier->document_id = $request->document_id;
        $supplier->liability_id = $request->liability_id;
        $supplier->organization_id = $request->organization_id;
        $supplier->regime_id = $request->regime_id;
        $supplier->name = $request->name;
        $supplier->number = $request->number;
        $supplier->dv = $request->dv;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->contact = $request->contact;
        $supplier->phone_contact = $request->phone_contact;
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

    public function getMunicipalities(Request $request, $id)
    {
        if($request)
        {
            $municipalities = Municipality::where('department_id', '=', $id)->get();

            return response()->json($municipalities);
        }
    }
}
