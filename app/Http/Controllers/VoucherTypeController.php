<?php

namespace App\Http\Controllers;

use App\Models\Voucher_type;
use App\Http\Requests\StoreVoucher_typeRequest;
use App\Http\Requests\UpdateVoucher_typeRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VoucherTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $voucherTypes = Voucher_type::all();

            return DataTables::of($voucherTypes)
                ->addIndexColumn()
                ->addColumn('state', function (Voucher_type $voucherType) {
                    return $voucherType->state == 'inactive' ? 'Inactivo' : 'Activo';
                })
                ->addColumn('actions', 'admin/voucher_type/actions')
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.voucher_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.voucher_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVoucher_typeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVoucher_typeRequest $request)
    {
        Voucher_type::create($request->all());

        return redirect()->route('voucher_type')->with(
            'success_message',
            'Tipo de comprobante registrado con éxito.'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher_type  $voucher_type
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher_type $voucher_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher_type  $voucher_type
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher_type $voucher_type)
    {
        return view('admin.voucher_type.edit', compact('voucher_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVoucher_typeRequest  $request
     * @param  \App\Models\Voucher_type  $voucher_type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVoucher_typeRequest $request, Voucher_type $voucher_type)
    {
        $voucher_type->update($request->all());

        return redirect()->route('voucher_type')->with(
            'success_message',
            'Tipo de comprobante editado con éxito.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher_type  $voucher_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher_type $voucher_type)
    {
        $voucher_type->delete();

        return redirect()->route('voucher_types.index')->with(
            'success_message',
            'Tipo de comprobante eliminado con éxito.'
        );
    }
}
