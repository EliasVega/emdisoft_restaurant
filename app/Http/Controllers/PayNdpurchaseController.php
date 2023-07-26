<?php

namespace App\Http\Controllers;

use App\Models\Pay_ndpurchase;
use App\Http\Requests\StorePay_ndpurchaseRequest;
use App\Http\Requests\UpdatePay_ndpurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PayNdpurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        if (request()->ajax()) {
            if ($user->role_id == 1 || $user->role_id == 2) {
                $pay_ndpurchases = Pay_ndpurchase::get();
            } else {
                $pay_ndpurchases = Pay_ndpurchase::where('branch_id', $user->branch_id)->where('user_id', $user->id)->get();
            }
            return DataTables::of($pay_ndpurchases)
            ->addIndexColumn()
            ->addColumn('supplier', function (Pay_ndpurchase $payNdpurchase) {
                return $payNdpurchase->purchase->supplier->name;
            })
            ->addColumn('branch', function (Pay_ndpurchase $payNdpurchase) {
                return $payNdpurchase->branch->name;
            })
            ->editColumn('created_at', function(Pay_ndpurchase $payNdpurchase){
                return $payNdpurchase->created_at->format('yy-m-d: h:m');
            })
            ->addColumn('btn', 'admin/pay_ndpurchase/actions')
            ->rawColumns(['btn'])
            ->make(true);
        }
        return view('admin.pay_ndpurchase.index');
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
     * @param  \App\Http\Requests\StorePay_ndpurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePay_ndpurchaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pay_ndpurchase  $pay_ndpurchase
     * @return \Illuminate\Http\Response
     */
    public function show(Pay_ndpurchase $pay_ndpurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pay_ndpurchase  $pay_ndpurchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Pay_ndpurchase $pay_ndpurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePay_ndpurchaseRequest  $request
     * @param  \App\Models\Pay_ndpurchase  $pay_ndpurchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePay_ndpurchaseRequest $request, Pay_ndpurchase $pay_ndpurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pay_ndpurchase  $pay_ndpurchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pay_ndpurchase $pay_ndpurchase)
    {
        //
    }
}
